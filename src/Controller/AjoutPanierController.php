<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Orders;
use App\Entity\Orderslines;
use App\Entity\Articles;


class AjoutPanierController extends AbstractController
{
    #[Route('/add/{id}', name: 'app_ajout_panier')]
    public function addPanier(ManagerRegistry $doctrine, $id): Response
    {
        var_dump($id);
        return $this->render('ajout_panier/index.html.twig', [
            'controller_name' => 'AjoutPanierController',
        ]);
    }
}
