<?php

declare(strict_types=1);

namespace App\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\TopBook;
use App\Repository\TopBook\TopBookDataInterface;
use App\State\Extension\TopBookCollectionExtensionInterface;
use Doctrine\ORM\EntityManagerInterface;
final class EntityXCollectionProvider implements ProviderInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array
    {
        $sql = <<<SQL
SELECT y.id, y.name, 'y' as entity
  FROM entity_y as y
 UNION
 SELECT z.id, z.name, 'z' as entity
   FROM entity_z as z ;
SQL;

        $connection = $this->entityManager->getConnection();
        $result = $connection
            ->prepare($sql)
            ->executeQuery()
            ->fetchAllAssociative()
        ;

        return $result;
    }
}
