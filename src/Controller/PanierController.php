<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Orders;
use App\Entity\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\RequestStack;


class PanierController extends AbstractController
{
    private $requestStack;
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;

        // Accessing the session in the constructor is *NOT* recommended, since
        // it might not be accessible yet or lead to unwanted side-effects
        // $this->session = $requestStack->getSession();
    }
    #[Route('/cart', name: 'app_panier')]
    public function panier(ManagerRegistry $doctrine, AuthenticationUtils $authenticationUtils): Response
    {

        $lastUsername = $authenticationUtils->getLastUsername();
        if ($lastUsername != null) {
            $user = $doctrine->getRepository(User::class)->findOneBy(['email' => $lastUsername]);
            $userId = $user->getId();
            $order = $doctrine->getRepository(Orders::class)->findOneBy(['user' => $userId, 'status' => 'panier']);
            $index = 0;
        } else {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController', 'order' => $order, 'index' => $index
        ]);
    }

    #[Route('/cart/{id}', name: 'app_delete_panier')]
    public function deletePanier(ManagerRegistry $doctrine, AuthenticationUtils $authenticationUtils, $id): Response
    {
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($lastUsername != null) {
            $user = $doctrine->getRepository(User::class)->findOneBy(['email' => $lastUsername]);
            $userId = $user->getId();
            $order = $doctrine->getRepository(Orders::class)->findOneBy(['user' => $userId, 'status' => 'panier']);
            $entityManager = $doctrine->getManager();
            foreach ($order->getOrderslines() as $orderline) {
                if ($orderline->getId() == $id) {
                    $amount = $order->getAmount() - ($orderline->getArticle()->getPrice() * $orderline->getQuantity());
                    $order->setAmount($amount);
                    $order->removeOrdersline($orderline);
                    $entityManager->flush();
                    break;
                }
            }
            $index = 0;
        } else {
            return $this->redirectToRoute('app_login');
        }
        $session = $this->requestStack->getSession();
        $amount = 0;
        $quantity = 0;
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($lastUsername != null) {
            $user = $doctrine->getRepository(User::class)->findOneBy(['email' => $lastUsername]);
            $userId = $user->getId();
            $order = $doctrine->getRepository(Orders::class)->findOneBy(['user' => $userId, 'status' => 'panier']);
            if ($order != null) {
                $amount = $order->getAmount();
                foreach ($order->getOrdersLines() as $orderline) {
                    $quantity = $quantity + $orderline->getQuantity();
                }
            }
        }
        $session->set('amount', $amount);
        $session->set('quantity', $quantity);
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController', 'order' => $order, 'index' => $index
        ]);
    }


    #[Route('/cart/update/{action}/{id}', name: 'app_recalculate_panier')]
    public function recalculerPanier(ManagerRegistry $doctrine, AuthenticationUtils $authenticationUtils, $action, $id): Response
    {

        $lastUsername = $authenticationUtils->getLastUsername();
        if ($lastUsername != null) {
            $user = $doctrine->getRepository(User::class)->findOneBy(['email' => $lastUsername]);
            $userId = $user->getId();
            $order = $doctrine->getRepository(Orders::class)->findOneBy(['user' => $userId, 'status' => 'panier']);
            $entityManager = $doctrine->getManager();
            foreach ($order->getOrderslines() as $orderline) {
                if ($orderline->getId() == $id) {
                    if ($action == "minus") {
                        $quantity = $orderline->getQuantity();
                        if ($quantity > 1) {
                            $quantity = $quantity - 1;
                            $orderline->setQuantity($quantity);
                            $amount = $order->getAmount() - ($orderline->getArticle()->getPrice());
                            $order->setAmount($amount);
                        }
                    }
                    if ($action == "plus") {
                        $quantity = $orderline->getQuantity() + 1;
                        $orderline->setQuantity($quantity);
                        $amount = $order->getAmount() + ($orderline->getArticle()->getPrice());
                        $order->setAmount($amount);
                    }

                    $entityManager->flush();
                    break;
                }
            }
            $index = 0;
        } else {
            return $this->redirectToRoute('app_login');
        }

        $session = $this->requestStack->getSession();
        $amount = 0;
        $quantity = 0;
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($lastUsername != null) {
            $user = $doctrine->getRepository(User::class)->findOneBy(['email' => $lastUsername]);
            $userId = $user->getId();
            $order = $doctrine->getRepository(Orders::class)->findOneBy(['user' => $userId, 'status' => 'panier']);
            if ($order != null) {
                $amount = $order->getAmount();
                foreach ($order->getOrdersLines() as $orderline) {
                    $quantity = $quantity + $orderline->getQuantity();
                }
            }
        }
        $session->set('amount', $amount);
        $session->set('quantity', $quantity);

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController', 'order' => $order, 'index' => $index
        ]);
    }
}
