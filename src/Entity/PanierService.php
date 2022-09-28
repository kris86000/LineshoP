<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\RequestStack;

class PanierService
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;

        // Accessing the session in the constructor is *NOT* recommended, since
        // it might not be accessible yet or lead to unwanted side-effects
        // $this->session = $requestStack->getSession();
    }

    public function majPanier($amount, $quantity)
    {

        $session = $this->requestStack->getSession();

        // stores an attribute in the session for later reuse
        $session->set('amount', $amount);
        $session->set('quantity', $quantity);
    }
}
