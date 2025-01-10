<?php

namespace App\DoctrineListener\Discussion;


use App\Entity\Discussion\Discussion;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postPersist, entity: Discussion::class)]
class CreateDiscussionNotificationListener
{
    public function postPersist(Discussion $discussion, PostPersistEventArgs $event): void
    {
         // $discussion->getParticipants()
    }
}
