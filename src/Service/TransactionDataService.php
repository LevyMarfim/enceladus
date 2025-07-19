<?php
// src/Service/TransactionDataService.php

namespace App\Service;

use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use DateTime;

class TransactionDataService
{
    public function __construct(
        private TransactionRepository $transactionRepository
    ) {
    }

    public function getChartData(array $filters = []): array
    {
        // Apply filters to repository queries
        $transactions = $this->transactionRepository->findByFilters($filters);
        
        // Group data by month/year for the chart
        $data = [];
        foreach ($transactions as $transaction) {
            $dateKey = $transaction->getTransactionDate()->format('Y-m');
            
            if (!isset($data[$dateKey])) {
                $data[$dateKey] = [
                    'label' => $transaction->getTransactionDate()->format('M Y'),
                    'value' => 0,
                ];
            }
            
            $data[$dateKey]['value'] += $transaction->getValue();
        }
        
        // Sort by date
        ksort($data);
        
        return [
            'labels' => array_column($data, 'label'),
            'datasets' => [
                [
                    'label' => 'Transaction Values',
                    'data' => array_column($data, 'value'),
                    'backgroundColor' => '#4f46e5',
                    'borderColor' => '#4f46e5',
                ]
            ]
        ];
    }
}