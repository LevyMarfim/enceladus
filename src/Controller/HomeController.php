<?php

namespace App\Controller;

use App\Enums\OperationEnum;
use App\Enums\TransactionTypeEnum;
use App\Repository\AssetRepository;
use App\Repository\TransactionRepository;
use App\Service\TransactionDataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TransactionDataService $transactionDataService, Request $request, AssetRepository $assetRepository, TransactionRepository $transactionRepository): Response
    {
        $filters = $request->query->all();
        $chartData = $transactionDataService->getChartData($filters);

        if ($request->isXmlHttpRequest()) {
            return $this->json([
                'chartData' => $chartData,
            ], 200, [], [
                'groups' => ['chart_data'] // Add this if you need serialization groups
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
            'years' => array_column($years, 'year'),
        ]);
    }
}
