<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyForm;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/company/new', name: 'app_company_new')]
    public function addCompany(Request $request, EntityManagerInterface $entityManager): Response
    {
        $company = new Company();

        $form = $this->createForm(CompanyForm::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($company);
            $entityManager->flush();

            return $this->redirectToRoute('app_company_list');
        }

        return $this->render('company/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/company/list', name: 'app_company_list')]
    public function listSector(CompanyRepository $repository): Response
    {
        return $this->render('company/list.html.twig', [
            'companies' => $repository->findAll(),
        ]);
    }
}
