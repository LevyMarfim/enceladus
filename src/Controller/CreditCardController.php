<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CreditCardController extends AbstractController
{
    #[Route('/credit/card', name: 'app_credit_card')]
    public function index(): Response
    {
        return $this->render('credit_card/index.html.twig', [
            'controller_name' => 'CreditCardController',
        ]);
    }
}
