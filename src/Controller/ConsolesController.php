<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Articles;

class ConsolesController extends AbstractController
{
    #[Route('/consoles', name: 'app_consoles')]
    public function afficherConsole(ManagerRegistry $doctrine): Response
    {
        $allConsole = $doctrine->getRepository(Articles::class)->findBy(['categories' => '1']);

        return $this->render('consoles/index.html.twig', [
            'controller_name' => 'ConsolesController',
            'allConsole' => $allConsole,
        ]);
    }
}
