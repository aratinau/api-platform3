<?php

namespace App\Serializer\Normalizer;

use App\Attribute\ApiAuthGroups;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ApiAuthNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    private const ALREADY_CALLED_NORMALIZER = 'AlreadyCalledApiAuthNormalizer';

    public function __construct(
        private ObjectNormalizer $normalizer,
        private AuthorizationCheckerInterface $authorizationChecker
    ) {
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        if (!is_object($data)) {
            return false;
        }

        $class = new \ReflectionClass(get_class($data));
        $classAttributes = $class->getAttributes(ApiAuthGroups::class);
        $alreadyCalled = $context[self::ALREADY_CALLED_NORMALIZER] ?? false;

        return $alreadyCalled === false && !empty($classAttributes);
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        $class = new \ReflectionClass(get_class($object));
        $apiAuthGroups = $class->getAttributes(ApiAuthGroups::class)[0]->newInstance();

        foreach($apiAuthGroups->groups as $role => $groups) {
            if ($this->authorizationChecker->isGranted($role, $object)) {
                $context['groups'] = array_merge($context['groups'] ?? [], $groups);
            }
        }

        $context[self::ALREADY_CALLED_NORMALIZER] = true;

        return $this->normalizer->normalize($object, $format, $context);
    }


    public function hasCacheableSupportsMethod(): bool
    {
        return false;
    }
}
