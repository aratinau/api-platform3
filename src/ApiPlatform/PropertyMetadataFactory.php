<?php

namespace App\ApiPlatform;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Property\Factory\PropertyMetadataFactoryInterface;

class PropertyMetadataFactory implements PropertyMetadataFactoryInterface
{
    public function __construct(
        private readonly ?PropertyMetadataFactoryInterface $decorated = null
    ) {
    }

    public function create(string $resourceClass, string $property, array $options = []): ApiProperty
    {
        $propertyMetadata = $this->decorated->create($resourceClass, $property, $options);

        return $propertyMetadata;
    }

}
