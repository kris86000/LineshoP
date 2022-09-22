<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreationCompteController extends AbstractController
{
    #[Route('/creation', name: 'app_creation_compte')]
    public function index(): Response
    {
        return $this->render('creation_compte/index.html.twig',  [
            'controller_name' => 'CreationCompteController'
        ]);
    }
}
