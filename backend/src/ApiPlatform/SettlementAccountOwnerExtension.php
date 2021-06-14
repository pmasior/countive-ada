<?php


namespace App\ApiPlatform;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\MethodOfPayment;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

/**
 * Modify query that it returns entity objects only for logged in user
 * @package App\ApiPlatform
 */
class SettlementAccountOwnerExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private $security;
    const ACCEPTED_RESOURCE_CLASS = [
        MethodOfPayment::class
    ];

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $this->addWhereOnlyOwner($resourceClass, $queryBuilder);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
        $this->addWhereOnlyOwner($resourceClass, $queryBuilder);
    }

    private function addWhereOnlyOwner(string $resourceClass, QueryBuilder $queryBuilder): void
    {
        if (!in_array($resourceClass, self::ACCEPTED_RESOURCE_CLASS)) {
            return;
        }

        if (!$this->security->getUser()) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->innerJoin($rootAlias . '.settlementAccount', 's')
            ->andWhere('s.userAccount = :userAccountId')
            ->setParameter('userAccountId', $this->security->getUser());
    }
}
