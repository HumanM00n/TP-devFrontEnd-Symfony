<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Faker\Factory;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // =======================================================
        // 1. GÉNÉRATION DES DONNÉES AVEC FAKER
        // =======================================================
        $faker = Factory::create('fr_FR');
        $totalVehicles = 10; 
        $vehicles = [];
        $brands = ['Audi', 'Volkswagen', 'Seat', 'Skoda', 'Honda', 'Ducati'];
        $fuels = ['Essence', 'Diesel', 'Hybride', 'Électrique'];
        $categories = [
            ['label' => 'Prix en baisse', 'class' => 'style="background-color: #190885;"'],
            ['label' => 'Petit prix', 'class' => 'style="background-color: #198754;"'],
            ['label' => 'Pépite', 'class' => 'style="background-color: #ffc107;"']
        ];

        for ($i = 0; $i < $totalVehicles; $i++) {
            // Cycle entre les trois catégories pour les 10 véhicules
            $category = $categories[$i % count($categories)]; 
            
            $vehicles[] = [
                'title' => $faker->randomElement($brands) . ' ' . $faker->safeColorName(),
                'price' => $faker->numberBetween(10000, 75000),
                'year' => $faker->numberBetween(2015, 2024),
                'mileage' => $faker->numberBetween(1000, 150000),
                'fuel' => $faker->randomElement($fuels),
                'description' => $faker->realText(100),
                'category_label' => $category['label'],
                'category_class' => $category['class'],
                'image_url' => "https://picsum.photos/640/480?random=" . $i, 
            ];
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'vehicles' => $vehicles, 
        ]);
    }
}