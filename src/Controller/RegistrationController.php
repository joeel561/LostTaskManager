<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
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
   }

    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $content = json_decode($request->getContent(), true);

        if($content['email']) {
            $user = new User();
            $password = $content['password'];
            
            $user->setUsername($content['username']);
            $user->setEmail($content['email']);
            $user->setPassword($passwordEncoder->encodePassword($user, $password));
            $this->updateDatabase($user);

            return $this->json([
                'user' => $user->getEmail()
            ]);
        }

        return new Response('Error', Response::HTTP_NOT_FOUND);
    }

    function updateDatabase($object) 
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }
}
