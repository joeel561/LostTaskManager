<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Route("/projects/{id}", name="project_detail")
     */
    public function index()
    {
        return $this->render('home/home.html.twig', []);
    }
}
