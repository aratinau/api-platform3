<?php

namespace App\DoctrineListener;

use App\Attribute\WatchProperty;
use App\Entity\Todo;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use ReflectionClass;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsDoctrineListener(Events::preUpdate/*, 500, 'default'*/)]
class WatchPropertyPreUpdateListener
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Todo) {
            return;
        }

        $reflectionClass = new ReflectionClass($entity);

        foreach ($reflectionClass->getProperties() as $property) {
            $attributes = $property->getAttributes(WatchProperty::class);
            foreach ($attributes as $attribute) {
                /** @var WatchProperty $instance */
                $instance = $attribute->newInstance();
                $newValue = $property->getValue($entity);
                $oldValue = $args->getOldValue($property->getName());

                if ($triggerEventName = $instance->triggerEventName) {

                    $event = new \App\Event\CustomEvent(
                        message: sprintf('Custom event triggered for %s::%s', get_class($entity), $property->getName()),
                        data: [
                            'entity' => $entity,
                            'property' => $property->getName(),
                            'newValue' => $newValue,
                            'oldValue' => $oldValue
                        ]
                    );
                    $this->eventDispatcher->dispatch($event, $triggerEventName);
                }
            }
        }
    }
}
