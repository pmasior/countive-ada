<?php

namespace App\Repository;

use App\Entity\SubcategoryBudget;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubcategoryBudget|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubcategoryBudget|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubcategoryBudget[]    findAll()
 * @method SubcategoryBudget[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubcategoryBudgetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubcategoryBudget::class);
    }
}
