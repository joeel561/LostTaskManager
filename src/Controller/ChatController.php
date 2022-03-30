<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\PrivateMessage;
use App\Entity\Chatroom;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    /*
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $userRepository;
    
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $chatroomRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $entityManager->getRepository('App:User');
        $this->chatroomRepository = $entityManager->getRepository('App:Chatroom');
        $this->chatsRepository = $entityManager->getRepository('App:PrivateMessage');
    }

    /**
     * @Route("/chat", name="chat")
     */
    public function index(): Response
    {
        return $this->render('chat/index.html.twig');
    }

    /** 
     * @Route("/chat/list", name="chatrooms")
     */
    public function allChatrooms(): Response
    {
        $sender = ($this->getUser());
        $getSenderChatrooms = $this->chatroomRepository->getSenderChatrooms($sender);
        $jsonContent = $this->serializeObject($getSenderChatrooms);
        return new Response($jsonContent, Response::HTTP_OK);
    }

    /** 
     * @Route("/chat/list/{id}", name="private_chat")
     */
    public function allPrivateMessages(Request $request,int $id)
    {
        $sender = ($this->getUser());
        $activeChat = $this->userRepository->find($id);
        $chatroom = $this->chatroomRepository->getChatrooms($sender, $activeChat);

        $encoders = new JsonEncoder();

        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($obj) {
                return $obj->getId();
            }
        ];

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $normalizers = new ObjectNormalizer($classMetadataFactory, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([new DateTimeNormalizer(),$normalizers], [$encoders]);
        $jsonContent = $serializer->serialize($chatroom, 'json', [AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true, 'groups' => 'privat_messages']);
       
        return new Response($jsonContent, Response::HTTP_OK);
    }

    /** 
     * @Route("/chat/list/{id}/deleteChat", name="delete_private_chat")
     */
    public function deletePrivateMessage(Request $request,int $id)
    {
        $currentChatroom = $this->chatroomRepository->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($currentChatroom);
        $entityManager->flush();

        return new Response(Response::HTTP_OK);
    }

    public function serializeObject($object)
    { 
        $encoders = new JsonEncoder();

        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($obj) {
                return $obj->getId();
            }
        ];

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $normalizers = new ObjectNormalizer($classMetadataFactory, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([new DateTimeNormalizer(),$normalizers], [$encoders]);
        $jsonContent = $serializer->serialize($object, 'json', [AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true, 'groups' => 'chatroom_user', 'privat_messages']);

        return $jsonContent;
    }
}
