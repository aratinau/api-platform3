<?php

namespace App\Serializer;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Serializer\SerializerContextBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SerializerContextBuilder implements SerializerContextBuilderInterface
{
    public function __construct(
        private readonly SerializerContextBuilderInterface $decorated,
        private AuthorizationCheckerInterface $authorizationChecker
    ) {
    }

    public function createFromRequest(Request $request, bool $normalization, array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
        $context['groups'] = $context['groups'] ?? [];

        $isAdmin = $this->authorizationChecker->isGranted('ROLE_ADMIN');

        $context['groups'] = array_merge(
            $context['groups'],
            $this->addDefaultGroups($context, $normalization)
        );

        if ($isAdmin) {
            $context['groups'][] = $normalization ? 'admin:read' : 'admin:write';
        }

        $context['groups'] = array_unique($context['groups']);

        return $context;
    }

    private function addDefaultGroups(array $context, bool $normalization)
    {
        $resourceClass = $context['resource_class'] ?? null;
        if (!$resourceClass) {
            return;
        }

        $shortName = (new \ReflectionClass($resourceClass))->getShortName();
        $classAlias = strtolower(preg_replace('/[A-Z]/', '_\\0', lcfirst($shortName)));
        $readOrWrite = $normalization ? 'read' : 'write';

        $itemOrCollection = $context['operation'] instanceof GetCollection ?? false;

        $operationName =
            strtolower(
                preg_replace('/[A-Z]/', '\\0', lcfirst($context['operation']::class)
                )
            )
        ;
        $operationName = explode('\\', $operationName);
        $operationName = end($operationName);

        return [
            // {class}:{read/write}
            // e.g. user:read
            sprintf('%s:%s', $classAlias, $readOrWrite),

            // {class}:{item/collection}:{read/write}
            // e.g. user:collection:read
            sprintf('%s:%s:%s', $classAlias, $itemOrCollection, $readOrWrite),

            // {class}:{item/collection}:{operationName}
            // e.g. user:collection:get
            sprintf('%s:%s:%s', $classAlias, $itemOrCollection, $operationName),
        ];
    }
}
