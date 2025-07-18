<?php

namespace App\Controller;

use App\Entity\Asset;
use App\Form\AssetForm;
use App\Repository\AssetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AssetController extends AbstractController
{
    #[Route('/asset', name: 'app_asset')]
    public function index(): Response
    {
        return $this->render('asset/index.html.twig');
    }

    #[Route('/asset/new', name: 'app_asset_new')]
    public function addAsset(Request $request, EntityManagerInterface $entityManager): Response
    {
        $asset = new Asset();

        $form = $this->createForm(AssetForm::class, $asset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($asset);
            $entityManager->flush();

            return $this->redirectToRoute('app_asset_list');
        }

        return $this->render('asset/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/asset/assets', name: 'app_asset_list')]
    public function listAsset(AssetRepository $repository): Response
    {
        return $this->render('asset/list.html.twig', [
            'assets' => $repository->findAll(),
        ]);
    }
}
