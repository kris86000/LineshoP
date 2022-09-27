<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Orders;
use App\Entity\Orderslines;
use App\Entity\Articles;
use App\Entity\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AjoutPanierController extends AbstractController
{
    #[Route('/add/{idArticle}', name: 'app_ajout_panier')]
    public function addPanier(ManagerRegistry $doctrine, AuthenticationUtils $authenticationUtils, $idArticle): Response
    {
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($lastUsername != null) {
            $user = $doctrine->getRepository(User::class)->findOneBy(['email' => $lastUsername]);
            $userId = $user->getId();
            //echo $userId;
            $order = $doctrine->getRepository(Orders::class)->findOneBy(['user' => $userId, 'status' => 'panier']);
            if ($order != null) {
                $orderLine = $doctrine->getRepository(Orderslines::class)->findOneBy(['articles' => $idArticle]);
                if ($orderLine != null) {
                    $quantity = $orderLine->getQuantity() + 1;
                    $orderLine->setQuantity($quantity);
                } else {
                    $orderLine = new Orderslines;
                    $orderLine->setArticle($idArticle);
                    $orderLine->setQuantity(1);
                    $orderId = $order->getId();
                    $orderLine->setOrders($orderId);
                    $order->addOrdersline($orderLine);
                }
            } else {
                $order = new Orders;
                // $dateHeureActuel = date("Y-m-d H:i:s");
                $dateHeureActuel = new \DateTimeImmutable;
                $dateHeureActuel->setDate(date('Y'), date('m'), date('d'));
                $dateHeureActuel->setTime(date('H'), date('i'), date('s'));
                $dateHeureActuel->format("Y-m-d H:i:s");
                var_dump($dateHeureActuel);
                $order->setDateOrder($dateHeureActuel);
                $order->setAmount('100');
                $order->setStatus('panier');
                $order->setUser($user);
                $entityManager = $doctrine->getManager();
                $entityManager->getRepository(Orders::class)->add($order);
                $entityManager->flush();
            }
        } else {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('ajout_panier/index.html.twig', [
            'controller_name' => 'AjoutPanierController',
        ]);
    }
}
