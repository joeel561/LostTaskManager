<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UserController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     * 
     * 
     * 
     */
    private $entityManager;
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $userRepository;

    /**
     * ProjectController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $entityManager->getRepository('App:User');
    }

    /**
     * @Route("/users", name="user")
     */
    public function index()
    {
        $user = $this->userRepository->findAll();
        $jsonContent = $this->serializeObject($user);

        return new Response($jsonContent, Response::HTTP_OK);
    }

    public function serializeObject($object)
    { 
        $encoders = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($obj) {
                return $obj->getId();
            },
        ];

        $normalizers = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer(array($normalizers), array($encoders));
        $jsonContent = $serializer->serialize($object, 'json');

        return $jsonContent;
    }
}
