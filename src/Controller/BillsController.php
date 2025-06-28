<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BillsController extends AbstractController
{
    #[Route('/bills', name: 'app_bills')]
    public function index(): Response
    {
        return $this->render('bills/bills-index.html.twig', [
            'controller_name' => 'BillsController',
        ]);
    }
}
