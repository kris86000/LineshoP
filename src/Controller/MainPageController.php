<?php

namespace App\Controller;

use App\Entity\Articles;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Entity\Orders;
use Symfony\Component\HttpFoundation\Session\Session;

class MainPageController extends AbstractController
{

    #[Route('/', name: 'app_main_page')]

    public function affichageArticle(ManagerRegistry $doctrine, AuthenticationUtils $authenticationUtils): Response
    {
        $session = new Session();
        $session->start();
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
        $request = new RequestStack;
        $servicePanier = new PanierService($request);
        $servicePanier->majPanier($amount, $quantity);
        return $this->render('main_page/index.html.twig', [
            'controller_name' => 'MainPageController',
            'allArticles' => $allArticles

        ]);
    }
};
