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

    //    /**
    //     * @return Transaction[] Returns an array of Transaction objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Transaction
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

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
            $qb->andWhere('EXTRACT(YEAR FROM t.transactionDate) = :year')
            ->setParameter('year', $filters['year']);
        }
        
        if (!empty($filters['month'])) {
            $qb->andWhere('EXTRACT(MONTH FROM t.transactionDate) = :month')
            ->setParameter('month', $filters['month']);
        }
        
        return $qb->orderBy('t.transactionDate', 'ASC')
                ->getQuery()
                ->getResult();
    }

    public function getDistinctYears(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = 'SELECT DISTINCT EXTRACT(YEAR FROM transaction_date)::integer AS year 
                FROM transaction 
                ORDER BY year DESC';
        
        $result = $conn->executeQuery($sql)->fetchAllAssociative();
        
        return array_column($result, 'year');
    }
}
