<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transaction>
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function findByFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('t');
        
        if (!empty($filters['ticker'])) {
            $qb->andWhere('t.ticker = :ticker')
            ->setParameter('ticker', $filters['ticker']);
        }
        
        if (!empty($filters['operation'])) {
            $qb->andWhere('t.operation = :operation')
            ->setParameter('operation', $filters['operation']);
        }
        
        if (!empty($filters['type'])) {
            $qb->andWhere('t.type = :type')
            ->setParameter('type', $filters['type']);
        }
        
        if (!empty($filters['year'])) {
            $qb->andWhere('YEAR(t.transactionDate) = :year')
            ->setParameter('year', $filters['year']);
        }
        
        if (!empty($filters['month'])) {
            $qb->andWhere('MONTH(t.transactionDate) = :month')
            ->setParameter('month', $filters['month']);
        }
        
        return $qb->orderBy('t.transactionDate', 'ASC')
                ->getQuery()
                ->getResult();
    }

    public function getDistinctYears(): array
    {
        return $this->createQueryBuilder('t')
            ->select('DISTINCT YEAR(t.transactionDate) as year')
            ->orderBy('year', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
