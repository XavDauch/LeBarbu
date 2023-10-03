<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hellos', name: 'app_hellos')]
    public function index(): Response
    {
        return $this->render('hello/index.html.twig', [
            
        ]);
    }
}
