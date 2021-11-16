<?php 
namespace App\Component;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) 
    {
        $this->clients->attach($conn);
        $user = $conn->Session->get('_security.last_username');

        if (!$user) {
            $conn->close();
        }

        echo "New connection! ($conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) 
    {
        $sendDate = new \DateTime();
        $user = $from->Session->get('_security.last_username');
        $newMsg["chatText"] = $msg;
        $newMsg["chatDate"] = $sendDate->getTimestamp();
        $newMsg["chatUsername"] = $user;
        
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            //if ($from !== $client) {
                $client->send(json_encode($newMsg));
            //}
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