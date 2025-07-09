<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CompanyController extends AbstractController
{
    #[Route('/company', name: 'app_company')]
    public function index(): Response
    {
        return $this->render('company/index.html.twig');
    }

    #[Route('/company/new', name: 'app_new_company')]
    public function addCompany(Request $request): Response
    {
        $company = new Company();

        $form = $this->createForm(CompanyForm::class, $company);
        $form->handleRequest($request);

        return $this->render('company/new.html.twig', [
            'form' => $form,
        ]);
    }
}
