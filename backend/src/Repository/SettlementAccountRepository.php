<?php

namespace App\Repository;

use App\Entity\SettlementAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SettlementAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method SettlementAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method SettlementAccount[]    findAll()
 * @method SettlementAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettlementAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettlementAccount::class);
    }

    // /**
    //  * @return SettlementAccount[] Returns an array of SettlementAccount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SettlementAccount
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
