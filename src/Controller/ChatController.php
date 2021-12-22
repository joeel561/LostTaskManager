<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\PrivateMessage;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
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

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $entityManager->getRepository('App:User');
        $this->chatRepository = $entityManager->getRepository('App:PrivateMessage');
    }

    /**
     * @Route("/chat", name="chat")
     */
    public function index(): Response
    {
        return $this->render('chat/index.html.twig');
    }

    /** 
     * @Route("/chat/list", name="chat")
     */
    public function allPrivateMessage(): Response
    {
        $sender = ($this->getUser());
        $sendMessage = $this->userRepository->findBy(['id' => $sender]);
        $pimmel = $this->chatRepository->findBy(['id' => $sender]);
        $jsonContent = $this->serializeObject($pimmel);

    header('Content-type: application/json; charset=utf-8');
    print_r($jsonContent);
        die();
        return new Response($jsonContent, Response::HTTP_OK);
    }

    public function serializeObject($object)
    { 
        $encoders = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($obj) {
                return $obj->getId();
            }
        ];

        $normalizers = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizers], [$encoders]);
        $jsonContent = $serializer->serialize($object, 'json', [ AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true, AbstractNormalizer::ATTRIBUTES => ['sender' => ['sentMessages'], 'recipient' => ['receivedMessages']]]);

        return $jsonContent;
    }
}
