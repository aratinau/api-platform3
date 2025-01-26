<?php

namespace App\EventSubscriber;

use App\Event\CustomEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CustomEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'custom.event.name' => 'onCustomEvent',
        ];
    }

    public function onCustomEvent(CustomEvent $event): void
    {
        // Logique personnalisée
        dump('Custom event received: ' . $event->getMessage());
        dump($event->getData());
        dd('toto');
    }
}
