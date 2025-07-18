<?php

namespace App\Controller;

use App\Entity\Bill;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BillController extends AbstractController
{
    #[Route('/bill', name: 'app_bill')]
    public function index(): Response
    {
        return $this->render('bill/index.html.twig', [
            'controller_name' => 'BillsController',
        ]);
    }

    #[Route('/bill/new', name: 'app_bill_new')]
    public function addTransatcion(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bill = new Bill();

        $form = $this->createForm(TransactionForm::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($transaction);
            $entityManager->flush();

            return $this->redirectToRoute('app_transaction_list');
        }

        return $this->render('bill/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/bill/list', name: 'app_bill_list')]
    public function listAsset(TransactionRepository $repository): Response
    {
        return $this->render('bill/list.html.twig', [
            'transactions' => $repository->findAll(),
        ]);
    }
}
