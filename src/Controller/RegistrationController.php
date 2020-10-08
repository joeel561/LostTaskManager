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
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());

            $user->setPassword($password);

            $this->updateDatabase($user);

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    function updateDatabase($object) 
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }
}
