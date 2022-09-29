<?php

namespace App\Controller;

use App\Entity\Articles;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Entity\Orders;


class MainPageController extends AbstractController
{
    private $requestStack;
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;

        // Accessing the session in the constructor is *NOT* recommended, since
        // it might not be accessible yet or lead to unwanted side-effects
        // $this->session = $requestStack->getSession();
    }
    #[Route('/', name: 'app_main_page')]
    public function affichageArticle(ManagerRegistry $doctrine, AuthenticationUtils $authenticationUtils): Response
    {
        $session = $this->requestStack->getSession();
        $amount = 0;
        $quantity = 0;
        $allArticles = $doctrine->getRepository(Articles::class)->findAll();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($lastUsername == null) {
            $amount = 0;
            $quantity = 0;
        } else {
            $user = $doctrine->getRepository(User::class)->findOneBy(['email' => $lastUsername]);
            $userId = $user->getId();
            $order = $doctrine->getRepository(Orders::class)->findOneBy(['user' => $userId, 'status' => 'panier']);

            if ($order != null) {
                $amount = $order->getAmount();
                $quantity = 0;
                foreach ($order->getOrdersLines() as $orderline) {
                    $quantity = $quantity + $orderline->getQuantity();
                }
            }
        }
        $session->set('amount', $amount);
        $session->set('quantity', $quantity);
        return $this->render('main_page/index.html.twig', [
            'controller_name' => 'MainPageController',
            'allArticles' => $allArticles
        ]);
    }
    #[Route('/add', name: 'app_add_article')]
    public function ajoutArticle(ManagerRegistry $doctrine, AuthenticationUtils $authenticationUtils): Response
    {
        $session = $this->requestStack->getSession();
        $allArticles = $doctrine->getRepository(Articles::class)->findAll();
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
        return $this->render('main_page/index.html.twig', [
            'controller_name' => 'MainPageController',
            'allArticles' => $allArticles
        ]);
    }
};
