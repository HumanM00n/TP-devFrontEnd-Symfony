<?php

namespace App\Controller;

use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CountryController extends AbstractController
{
    #[Route('/country', name: 'app_country')]
    public function index(CountryRepository $countryRepository): Response
    {

        $countryList = $countryRepository->findAll();
        
        return $this->render('/country/index.html.twig', [
            'countryList' => $countryList,
        ]);
    }

    #[Route('/country/create', name: 'app_country_create')]
    public function form(Request $request, EntityManagerInterface $entityManager) : Response {

        $country = new Country();

        $form = $this->createForm(CountryType::class, $country);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if($form->isValid()) {
                // Enregistrement en base de données

                // Envoi un données à l'entity
                $entityManager->persist($country);
                // Envoi tous les persist
                $entityManager->flush();

               return $this->redirectToRoute('app_country');
            }
        }

        return $this->render('/country/form.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}
