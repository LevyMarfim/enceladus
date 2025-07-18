<?php

namespace App\Controller;

use App\Entity\Bill;
use App\Form\BillForm;
use App\Repository\BillRepository;
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
        return $this->render('bill/index.html.twig');
    }

    #[Route('/bill/new', name: 'app_bill_new')]
    public function addTransatcion(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bill = new Bill();

        $form = $this->createForm(BillForm::class, $bill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($bill);
            $entityManager->flush();

            return $this->redirectToRoute('app_bill_list');
        }

        return $this->render('bill/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/bill/list', name: 'app_bill_list')]
    public function listAsset(BillRepository $repository): Response
    {
        return $this->render('bill/list.html.twig', [
            'bills' => $repository->findAll(),
        ]);
    }
}
