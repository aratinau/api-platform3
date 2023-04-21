<?php

namespace App\State;

use App\Entity\BlogPost;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;

class BookPostProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }


    /**
     * {@inheritDoc}
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        // "hydra:description": "Unable to generate an IRI for the item of type \"App\\Entity\\Book\""
        // This was happening because the entity was never being saved, so the id was never generated.
        // https://stackoverflow.com/questions/57887026/unable-to-generate-an-iri-for-the-item-of-type-exception-after-api-platform-mi

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}
