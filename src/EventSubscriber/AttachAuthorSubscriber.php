<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\AuthorInterface;
use App\Entity\CurrentUserIsAuthorCollectionInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @deprecated - use AttachAuthorDoctrineListener.php
 */
class AttachAuthorSubscriber //implements EventSubscriberInterface
{
    public function __construct(
        private readonly Security $security
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ["setAuthor", EventPriorities::POST_DESERIALIZE]
        ];
    }

    public function setAuthor(RequestEvent $event)
    {
        $entity = $event->getRequest()->attributes->get('data');
        $method = $event->getRequest()->getMethod();

        if (!$entity instanceof AuthorInterface || Request::METHOD_POST !== $method) {
            return;
        }

        $user = $this->security->getUser();
        if (!$user) {
            return;
        }

        $entity->setAuthor($user);
    }
}
