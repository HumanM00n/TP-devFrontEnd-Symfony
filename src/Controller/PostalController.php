<?php

namespace App\Controller;

use App\Entity\Postal;
use App\Form\PostalType;
use App\Repository\PostalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/postal', name: 'app_postal_')]
final class PostalController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PostalRepository $postalRepository): Response
    {
        $postalList = $postalRepository->findAll();

        return $this->render('postal/index.html.twig', [
            'postalList' => $postalList,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function form(Request $request, EntityManagerInterface $entityManager): Response
    {
        $postal = new Postal();

        $form = $this->createForm(PostalType::class, $postal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($postal);
            $entityManager->flush();

            return $this->redirectToRoute('app_postal_index'); 
        }

        return $this->render('postal/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

