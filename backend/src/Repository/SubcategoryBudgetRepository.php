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

    // /**
    //  * @return SubcategoryBudget[] Returns an array of SubcategoryBudget objects
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
    public function findOneBySomeField($value): ?SubcategoryBudget
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
