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
            $entityManager = $doctrine->getManager();
            $order = $entityManager->getRepository(Orders::class)->findOneBy(['user' => $userId, 'status' => 'panier']);
            if ($order != null) {
                $thisOrderLine = null;
                foreach ($order->getOrderslines() as $orderLine) {
                    if ($orderLine->getArticle()->getId() == $idArticle) {
                        $quantity = $orderLine->getQuantity() + 1;
                        $orderLine->setQuantity($quantity);
                        $amount = $order->getAmount() + $orderLine->getArticle()->getPrice();
                        $order->setAmount($amount);
                        $thisOrderLine = $orderLine;
                        break;
                    }
                }
                if ($thisOrderLine == null) {
                    $article = $doctrine->getRepository(Articles::class)->find($idArticle);
                    $orderLine = new Orderslines;
                    $orderLine->setArticle($article);
                    $orderLine->setQuantity(1);
                    $orderLine->setOrders($order);
                    $amount = $order->getAmount() + $article->getPrice();
                    $order->setAmount($amount);
                    $order->addOrdersline($orderLine);
                }
                $entityManager->flush();
            } else {
                $order = new Orders;

                $article = $doctrine->getRepository(Articles::class)->find($idArticle);
                $orderLine = new Orderslines;
                $orderLine->setArticle($article);
                $orderLine->setQuantity(1);
                $orderLine->setOrders($order);
                $order->addOrdersline($orderLine);

                $dateHeureActuel = new \DateTimeImmutable;
                $dateHeureActuel->setDate(date('Y'), date('m'), date('d'));
                $dateHeureActuel->setTime(date('H'), date('i'), date('s'));
                $dateHeureActuel->format("Y-m-d H:i:s");
                var_dump($dateHeureActuel);
                $order->setDateOrder($dateHeureActuel);
                $order->setAmount($article->getPrice());
                $order->setStatus('panier');
                $order->setUser($user);
                $entityManager = $doctrine->getManager();
                $entityManager->getRepository(Orders::class)->add($order);
                $entityManager->flush();
            }
            return $this->redirectToRoute('app_main_page');
        } else {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('ajout_panier/index.html.twig', [
            'controller_name' => 'AjoutPanierController',
        ]);
    }
}
