<?php

namespace App\Repository;

use App\Entity\CategoryBudget;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryBudget|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryBudget|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryBudget[]    findAll()
 * @method CategoryBudget[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryBudgetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryBudget::class);
    }
}
