<?php

namespace App\Controller;

use App\Form\YourFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// #[IsGranted('ROLE_USER')]
final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/test', name: 'app_test')]
    public function yourAction(Request $request): Response
    {
        $form = $this->createForm(YourFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedItems = $form->get('options')->getData();
            // Debug selected items
            dump($selectedItems);
            
            // Redirect or render different template
            return $this->redirectToRoute('app_test_success');
            // OR if you want to render a template:
            // return $this->render('home/aaa.html.twig');
        }

        return $this->render('home/your_template.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/test/success', name: 'app_test_success')]
    public function successAction(): Response
    {
        return $this->render('home/aaa.html.twig');
    }
}
