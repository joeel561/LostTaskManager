<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * #[Route("/login", name: "login", methods: ["GET", "POST"])]
     */
    public function login(Request $request, AuthenticationUtils $authUtlis)
    {
        $error = $authUtlis->getLastAuthenticationError();

        $lastUsername = $authUtlis->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_name' => $lastUsername,
            'error' => $error,
        ]);
    }
}
