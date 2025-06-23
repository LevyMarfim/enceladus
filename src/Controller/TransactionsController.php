<?php

namespace App\Controller;

use App\Entity\Transactions;
use App\Form\TransactionForm;
use App\Repository\TransactionsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TransactionsController extends AbstractController
{
    #[Route('/transactions', name: 'app_transactions')]
    public function index(): Response
    {
        return $this->render('transactions/transactions-index.html.twig', [
            'controller_name' => 'TransactionsController',
        ]);
    }

    #[Route('/transactions/add', name: 'app_add_transactions')]
    public function addTransatcion(Request $request, EntityManagerInterface $entityManager): Response
    {
        $transaction = new Transactions();

        $form = $this->createForm(TransactionForm::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $transaction->setDate(new DateTime());
            $entityManager->persist($transaction);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('transactions/add-transaction.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/transactions/transactions', name: 'app_list_transactions')]
    public function listAsset(TransactionsRepository $repository): Response
    {
        return $this->render('transactions/list-transactions.html.twig', [
            'transactions' => $repository->findAll(),
        ]);
    }
}
