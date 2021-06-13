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
}
