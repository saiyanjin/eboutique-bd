<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // Import indispensable
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CatalogController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        ProductRepository $productRepository, 
        CategoryRepository $categoryRepository,
        Request $request
    ): Response {
        // 1. On récupère toutes les catégories pour le menu de tri
        $categories = $categoryRepository->findAll();

        // 2. On récupère l'ID de la catégorie depuis l'URL (ex: /?category=2)
        $categoryId = $request->query->get('category');

        if ($categoryId) {
            // Si une catégorie est précisée, on filtre les produits
            $products = $productRepository->findBy(['category' => $categoryId]);
        } else {
            // Sinon, on récupère tout
            $products = $productRepository->findAll();
        }

        return $this->render('catalog/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $categoryId, // Utile pour mettre le bouton en surbrillance
        ]);
    }
}