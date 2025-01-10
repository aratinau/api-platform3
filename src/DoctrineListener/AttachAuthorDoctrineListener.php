<?php

namespace App\DoctrineListener;

use App\Entity\AuthorInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Symfony\Bundle\SecurityBundle\Security;

#[AsDoctrineListener('prePersist'/*, 500, 'default'*/)]
class AttachAuthorDoctrineListener
{
    public function __construct(
        private Security $security
    ) {
    }

    public function prePersist(PrePersistEventArgs $event): void
    {
        // TODO: sortir si user est null pour le doc:fix:load
        $object = $event->getObject();

        if($object  instanceof AuthorInterface) {
            $user = $this->security->getUser();

            $object->setAuthor($user);
        }
    }
}
