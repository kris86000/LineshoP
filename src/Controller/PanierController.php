<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Orders;
use App\Entity\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PanierController extends AbstractController
{
    #[Route('/cart', name: 'app_panier')]
    public function panier(ManagerRegistry $doctrine, AuthenticationUtils $authenticationUtils): Response
    {
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($lastUsername != null) {
            $user = $doctrine->getRepository(User::class)->findOneBy(['email' => $lastUsername]);
            $userId = $user->getId();
            $order = $doctrine->getRepository(Orders::class)->findOneBy(['user' => $userId, 'status' => 'panier']);
            var_dump($userId);
        } else {
            return $this->redirectToRoute('app_login');
        }




        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController', 'order' => $order
        ]);
    }
}
