<?php

namespace App\Controller;

use App\Entity\Bottle;
use App\Form\BottleType;
use App\Repository\BottleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BottleController extends AbstractController
{
    #[Route('/users/{userSlug}/bottles', name: 'app_bottles_show')]
    public function index(
        string $userSlug, 
        BottleRepository $bottleRepository,
    ): Response 
    {
        $bottles = $bottleRepository->createQueryBuilder("b")
        ->select('b')
        ->join('b.user', 'u')
        ->where('u.slug = :userSlug')
        ->setParameter('userSlug', $userSlug)
        ->getQuery()
        ->getResult();
        
        return $this->render('bottle/show.html.twig', [
        'bottles' => $bottles,
        'userSlug' => $userSlug,
        ]);
    }
    #[Route('users/{userSlug}/bottles/new', name: 'app_bottles_new')]
    public function add(
       string $userSlug, 
       Request $request, 
       EntityManagerInterface $entityManagerInterface,
       bottleRepository $bottleRepository 
    ): Response
    {
        $form = $this->createForm(BottleType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $bottle = $form->getData();
            $entityManagerInterface->persist($bottle);
            $entityManagerInterface->flush();
            $this->addFlash("success", "Vous avez bien créé votre nouvelle bouteille");
            return $this->redirectToRoute("app_bottles_show", ['userSlug'=> $userSlug]);

        }
        return $this->render('bottle/new.html.twig', [
            "form" => $form,
            "userSlug" => $userSlug
     ]);
    }
    #[Route('users/{userSlug}/bottles/{slug}/edit', name: 'app_bottles_edit')]
    //#[IsGranted('ROLE_ADMIN')]
    public function edit(
        string $userSlug,
        Request $request, 
        EntityManagerInterface $em, 
        Bottle $bottle

    ): Response
    {
        $form = $this->createForm(BottleType::class, $bottle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute("app_bottles_show", ['userSlug'=> $userSlug]);
        }

        return $this->render('bottle/edit.html.twig', [
            'form' => $form,
            "userSlug" => $userSlug
        ]);
    }
        #[Route('user/{userSlug}/bottles/{slug}/delete', name: 'app_bottles_delete')]
    public function delete(
        string $userSlug,
        EntityManagerInterface $entityManagerInterface,
        Bottle $bottle
    ): Response
    {
        $entityManagerInterface->remove($bottle);
        $entityManagerInterface->flush();
        $this->addFlash("success", "Vous avez bien supprimé votre bouteille.");
        return $this->redirectToRoute("app_bottles_show", ['userSlug'=> $userSlug]);
    }
}
