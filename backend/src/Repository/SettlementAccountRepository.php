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
}
