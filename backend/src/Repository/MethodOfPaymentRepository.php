<?php

namespace App\Repository;

use App\Entity\MethodOfPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MethodOfPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method MethodOfPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method MethodOfPayment[]    findAll()
 * @method MethodOfPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MethodOfPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MethodOfPayment::class);
    }

    // /**
    //  * @return MethodOfPayment[] Returns an array of MethodOfPayment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MethodOfPayment
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
