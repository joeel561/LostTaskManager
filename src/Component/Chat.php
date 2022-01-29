<?php 
namespace App\Component;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\PrivateMessage;
use App\Entity\Chatroom;

class Chat implements MessageComponentInterface {

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $privateMessageRepository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $chatroomRepository;

    protected $clients;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->clients = new \SplObjectStorage;
        $this->entityManager = $entityManager;
        $this->privateMessageRepository = $entityManager->getRepository('App:PrivateMessage');
        $this->chatroomRepository = $entityManager->getRepository('App:Chatroom');
        $this->userRepository = $entityManager->getRepository('App:User');
    }

    public function onOpen(ConnectionInterface $conn) 
    {
        $user = $this->userRepository->find($conn->Session->get('userId'));
     

        if (!$user) {
            $conn->close();
            return; 
        }

        $this->clients->attach($conn);
        

        echo "New connection! ($conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) 
    {
        $privatMessages = $this->privateMessageRepository->findAll();

        $sendDate = new \DateTime();
        $senderId = $from->Session->get('userId');
        $senderName = $from->Session->get('_security.last_username');
        $newMsg = json_decode($msg, true);
        $newMsg["chatDate"] = $sendDate->getTimestamp();
        $newMsg["sender"] = ["id" => $senderId, "username" => $senderName];
        
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
        , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        
        $this->createChatRoom($newMsg);

        foreach ($this->clients as $client) {
            if ($client->Session->get('userId') == $newMsg["recv"] || $client->Session->get('userId') == $senderId) {
                $client->send(json_encode($newMsg));
            }
        }
    }

    
    private function createChatRoom($newMsg) 
    {
        $userRecv = $this->userRepository->find($newMsg['recv']);
        $userSender = $this->userRepository->find($newMsg['sender']['id']);
        $chatroom = $this->chatroomRepository->getChatrooms($userSender, $userRecv);
        $messageTimestamp = $newMsg['chatDate'];

        if (!$chatroom) {
            $chatroom = new Chatroom();
            $chatroom->setParticipant($userSender);
            $chatroom->setParticipant($userRecv);

            $this->entityManager->persist($chatroom);
            $this->entityManager->flush();
        }

        if ($chatroom) {
            $privatMessage = new PrivateMessage();
            $privatMessage->setSender($userSender);
            $privatMessage->setChatroom($chatroom[0]);
            $privatMessage->setText($newMsg['text']);
            $privatMessage->setCreatedAt(new \DateTime("@$messageTimestamp"));

            $this->entityManager->persist($privatMessage);
            $this->entityManager->flush();
        }

    }

    public function onClose(ConnectionInterface $conn) 
    {
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }


    public function onError(ConnectionInterface $conn, \Exception $e) 
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}