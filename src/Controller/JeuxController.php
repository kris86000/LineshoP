<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Articles;

class JeuxController extends AbstractController
{
    #[Route('/jeux', name: 'app_jeux')]
    public function afficherGames(ManagerRegistry $doctrine): Response
    {
        $allGames = $doctrine->getRepository(Articles::class)->findBy(['categories' => '2']);

        return $this->render('jeux/index.html.twig', [
            'controller_name' => 'JeuxController',
            'allGames' => $allGames,
        ]);
    }
}
