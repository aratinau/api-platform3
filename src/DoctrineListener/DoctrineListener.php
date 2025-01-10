<?php

namespace App\DoctrineListener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostPersistEventArgs;

#[AsDoctrineListener('postPersist'/*, 500, 'default'*/)]
class DoctrineListener
{
    public function postPersist(PostPersistEventArgs $event): void
    {
        // dd('');
    }
}
