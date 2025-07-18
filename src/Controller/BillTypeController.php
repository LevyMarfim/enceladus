<?php

namespace App\Controller;

use App\Entity\BillType;
use App\Form\BillTypeForm;
use App\Repository\BillTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BillTypeController extends AbstractController
{
    #[Route('/billtype', name: 'app_billtype')]
    public function index(): Response
    {
        return $this->render('billtype/index.html.twig', [
            'controller_name' => 'BilltypeController',
        ]);
    }

    #[Route('/billtype/new', name: 'app_billtype_new')]
    public function addAsset(Request $request, EntityManagerInterface $entityManager): Response
    {
        $billType = new BillType();

        $form = $this->createForm(BillTypeForm::class, $billType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($billType);
            $entityManager->flush();

            return $this->redirectToRoute('app_billtype_list');
        }

        return $this->render('billtype/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/billtype/list', name: 'app_billtype_list')]
    public function listAsset(BillTypeRepository $repository): Response
    {
        return $this->render('billtype/list.html.twig', [
            'billtypes' => $repository->findAll(),
        ]);
    }
}
