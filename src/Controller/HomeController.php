<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Enums\OperationEnum;
use App\Enums\TransactionTypeEnum;
use App\Form\YourFormType;
use App\Repository\AssetRepository;
use App\Repository\TransactionRepository;
use App\Service\TransactionDataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


final class HomeController extends AbstractController
{
    // #[Route('/', name: 'app_home')]
    // public function index(): Response
    // {
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }

    #[Route('/', name: 'app_home')]
    public function index(TransactionDataService $transactionDataService, Request $request, AssetRepository $assetRepository, TransactionRepository $transactionRepository): Response
    {
        $filters = $request->query->all();
        $chartData = $transactionDataService->getChartData($filters);

        if ($request->isXmlHttpRequest()) {
            return $this->json([
                'chartData' => $chartData,
            ]);
        }
        
        // Get distinct years from transactions
        $years = $transactionRepository->getDistinctYears();
        
        return $this->render('home/index.html.twig', [
            'chartData' => $chartData,
            'filters' => $filters,
            'assets' => $assetRepository->findAll(),
            'operations' => OperationEnum::cases(),
            'transactionTypes' => TransactionTypeEnum::cases(),
            // 'years' => $years,
            'years' => array_column($years, 'year'),
        ]);
    }
}
