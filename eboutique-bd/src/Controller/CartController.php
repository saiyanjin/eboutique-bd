<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart')]
class CartController extends AbstractController
{
    /**
     * Affiche le contenu du panier et le total
     */
    #[Route('/', name: 'app_cart_index')]
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * Ajoute un produit au panier
     */
    #[Route('/add/{id}', name: 'app_cart_add')]
    public function add(Product $product, CartService $cartService): Response
    {
        $cartService->add($product->getId());

        $this->addFlash('success', 'Bande dessinée ajoutée au panier !');

        return $this->redirectToRoute('app_cart_index');
    }

    /**
     * Diminue la quantité d'un produit
     */
    #[Route('/decrement/{id}', name: 'app_cart_decrement')]
    public function decrement(int $id, CartService $cartService): Response
    {
        $cartService->decrement($id);

        return $this->redirectToRoute('app_cart_index');
    }

    /**
     * Supprime complètement un article
     */
    #[Route('/remove/{id}', name: 'app_cart_remove')]
    public function remove(int $id, CartService $cartService): Response
    {
        $cartService->remove($id);

        return $this->redirectToRoute('app_cart_index');
    }
}