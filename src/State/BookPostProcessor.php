<?php

namespace App\State;

use App\Entity\BlogPost;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

class BookPostProcessor implements ProcessorInterface
{
    /**
     * {@inheritDoc}
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        // call your persistence layer to save $data
        return $data;
    }
}
