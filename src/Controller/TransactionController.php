<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionForm;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TransactionController extends AbstractController
{
    #[Route('/transaction', name: 'app_transaction')]
    public function index(): Response
    {
        return $this->render('transaction/index.html.twig');
    }

    #[Route('/transaction/new', name: 'app_transaction_new')]
    public function addTransatcion(Request $request, EntityManagerInterface $entityManager): Response
    {
        $transaction = new Transaction();

        $form = $this->createForm(TransactionForm::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($transaction);
            $entityManager->flush();

            return $this->redirectToRoute('app_transaction_list');
        }

        return $this->render('transaction/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/transaction/list', name: 'app_transaction_list')]
    public function listAsset(TransactionRepository $repository): Response
    {
        return $this->render('transaction/list.html.twig', [
            'transactions' => $repository->findAll(),
        ]);
    }
}
