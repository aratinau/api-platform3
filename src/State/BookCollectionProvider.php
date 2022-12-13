<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Doctrine\Orm\Extension\QueryResultCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\TopBook;
use App\Repository\TopBook\TopBookDataInterface;
use App\State\Extension\TopBookCollectionExtensionInterface;
use Doctrine\Persistence\ManagerRegistry;

final class BookCollectionProvider implements ProviderInterface
{
    public function __construct(
        private $collectionExtensions,
        private ManagerRegistry $managerRegistry,
    ) {
    }

    /**
     * @return iterable<TopBook>
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array
    {
        $resourceClass = $operation->getClass();

        $manager = $this->managerRegistry->getManagerForClass($resourceClass);
        $repository = $manager->getRepository($resourceClass);

        $queryNameGenerator = new QueryNameGenerator();
        $shortName = $operation->getShortName();
        $alias = $queryNameGenerator->generateParameterName($shortName);
        $queryBuilder = $repository->createQueryBuilder($alias);
        // $alias = $queryBuilder->getRootAliases()[0];

        foreach ($this->collectionExtensions as $extension) {
            /*
             * "ApiPlatform\Doctrine\Orm\Extension\FilterExtension"
             * "ApiPlatform\Doctrine\Orm\Extension\FilterEagerLoadingExtension"
             * "ApiPlatform\Doctrine\Orm\Extension\EagerLoadingExtension"
             * "ApiPlatform\Doctrine\Orm\Extension\OrderExtension"
             * "ApiPlatform\Doctrine\Orm\Extension\PaginationExtension"
             * */
            $extension->applyToCollection(
                $queryBuilder,
                $queryNameGenerator,
                $resourceClass,
                $operation,
                $context
            );

            if (
                $extension instanceof QueryResultCollectionExtensionInterface
                &&
                $extension->supportsResult($resourceClass, $operation, $context)
            ) {
                return $extension->getResult($queryBuilder, $resourceClass, $operation, $context);
            }
        }
    }
}
