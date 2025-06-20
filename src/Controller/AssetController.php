<?php

namespace App\Controller;

use App\Entity\Assets;
use App\Form\AssetForm;
use App\Repository\AssetsRepository;
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
        return $this->render('asset/assets-index.html.twig', [
            'controller_name' => 'AssetController',
        ]);
    }

    #[Route('/asset/add', name: 'app_add_asset')]
    public function addAsset(Request $request, EntityManagerInterface $entityManager): Response
    {
        $asset = new Assets();

        $form = $this->createForm(AssetForm::class, $asset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($asset);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('asset/add-asset.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/asset/assets', name: 'app_list_asset')]
    public function listAsset(AssetsRepository $repository): Response
    {
        return $this->render('asset/list-assets.html.twig', [
            'assets' => $repository->findAll(),
        ]);
    }
}
