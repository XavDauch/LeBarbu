<?php

namespace App\Controller;

use App\Repository\BottleRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BottleController extends AbstractController
{
    #[Route('/users/{user_slug}/bottles', name: 'app_bottles_show')]
public function index(
    string $user_slug, // Il semble que vous ayez déclaré cette variable comme $user_slug, mais l'utilisez comme $userSlug dans la route
    BottleRepository $bottleRepository,
   
): Response {
    $bottles = $bottleRepository->createQueryBuilder("t")
        ->select('t')
        ->join('t.user', 'u')
        ->where('u.slug = :userSlug')
        ->setParameter('userSlug', $user_slug)
        ->getQuery()
        ->getResult();
    
    return $this->render('bottle/show.html.twig', [
        'bottles' => $bottles
    ]);
}
}