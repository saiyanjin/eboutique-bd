<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    // On injecte RequestStack pour gérer la session et ProductRepository pour les données [cite: 49]
    public function __construct(
        private RequestStack $requestStack,
        private ProductRepository $productRepository
    ) {}

    /**
     * Ajoute un produit au panier ou augmente sa quantité [cite: 34]
     */
    public function add(int $id): void
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);
    }

    /**
     * Diminue la quantité d'un produit ou le retire s'il n'en reste qu'un [cite: 34, 38]
     */
    public function decrement(int $id): void
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }

        $session->set('cart', $cart);
    }

    public function clear(): void
    {
        $this->requestStack->getSession()->remove('cart');
    }

    /**
     * Retire complètement un produit du panier
     */
    public function remove(int $id): void
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);
    }

    /**
     * Récupère le panier complet avec les objets Product et leurs quantités [cite: 34, 49]
     */
    public function getFullCart(): array
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        $fullCart = [];

        foreach ($cart as $id => $quantity) {
            $product = $this->productRepository->find($id);
            if ($product) {
                $fullCart[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }

        return $fullCart;
    }

    /**
     * Calcule le montant total HT du panier [cite: 51]
     */
    public function getTotal(): float
    {
        $fullCart = $this->getFullCart();
        $total = 0;

        foreach ($fullCart as $item) {
            $total += $item['product']->getPriceHT() * $item['quantity'];
        }

        return $total;
    }
}