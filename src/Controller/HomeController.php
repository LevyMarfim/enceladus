<?php

namespace App\Controller;

use App\Form\YourFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    // src/Controller/YourController.php
    #[Route('/test', name: 'app_test')]
    public function yourAction(Request $request)
    {
        $form = $this->createForm(YourFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedItems = $form->get('options')->getData();
            // $selectedItems will be an array of selected entities/values
        }

        return $this->render('home/your_template.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
