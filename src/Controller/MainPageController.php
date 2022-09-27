<?php

namespace App\Controller;

use App\Entity\Articles;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainPageController extends AbstractController
{

    #[Route('/', name: 'app_main_page')]

    public function affichageArticle(ManagerRegistry $doctrine): Response
    {
        $allArticles = $doctrine->getRepository(Articles::class)->findAll();

        return $this->render('main_page/index.html.twig', [
            'controller_name' => 'MainPageController',
            'allArticles' => $allArticles

        ]);
    }
};
