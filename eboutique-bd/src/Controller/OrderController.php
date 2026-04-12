<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\CommandLine;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class OrderController extends AbstractController
{
    #[Route('/order/validate', name: 'app_order_validate')]
    #[IsGranted('ROLE_USER')] // L'utilisateur doit être connecté pour commander
    public function validate(CartService $cartService, EntityManagerInterface $em): Response
    {
        $fullCart = $cartService->getFullCart();

        if (empty($fullCart)) {
            $this->addFlash('warning', 'Votre panier est vide.');
            return $this->redirectToRoute('app_home');
        }

        // 1. Création de l'entité Order (Commande)
        $order = new Order();
        $order->setOrderNumber(uniqid('ORD-')); // Génère un numéro unique
        $order->setDateTime(new \DateTimeImmutable());
        $order->setisValid(true); // On considère valide pour l'exercice
        // $order->setUser($this->getUser()); // Si tu as lié Order à User

        // 2. Création des lignes de commande (CommandLine)
        foreach ($fullCart as $item) {
            $commandLine = new CommandLine();
            $commandLine->setProduct($item['product']);
            $commandLine->setQuantity($item['quantity']);
            $commandLine->setCommand($order); // On lie la ligne à la commande
            
            $em->persist($commandLine);
        }

        $em->persist($order);
        $em->flush(); // On enregistre tout en BDD

        // 3. Vider le panier (on peut ajouter une méthode clear() dans CartService)
        // Pour l'instant, on peut le faire manuellement via la session
        $cartService->remove(0); // Exemple, ou crée une méthode clear()

        return $this->render('order/success.html.twig', [
            'order' => $order
        ]);
    }
}