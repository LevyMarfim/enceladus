<?php

namespace App\Controller;

use App\Entity\Sector;
use App\Form\SectorForm;
use App\Repository\SectorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SectorController extends AbstractController
{
    #[Route('/sector', name: 'app_sector')]
    public function index(): Response
    {
        return $this->render('sector/index.html.twig', [
            'controller_name' => 'SectorController',
        ]);
    }

    #[Route('/sector/new', name: 'app_sector_new')]
    public function newSector(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sector = new Sector();

        $form = $this->createForm(SectorForm::class, $sector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($sector);
            $entityManager->flush();

            return $this->redirectToRoute('app_sector');
        }

        return $this->render('sector/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/sector/list', name: 'app_sector_list')]
    public function listSector(SectorRepository $repository): Response
    {
        return $this->render('sector/list.html.twig', [
            'sectors' => $repository->findAll(),
        ]);
    }
}
