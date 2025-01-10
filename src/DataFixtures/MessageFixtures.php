<?php

namespace App\DataFixtures;

use App\Entity\Discussion\Discussion;
use App\Factory\Discussion\DiscussionFactory;
use App\Factory\Discussion\MessageFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MessageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créer d'abord plusieurs discussions
        $discussions = DiscussionFactory::all();

        // Pour chaque discussion, créer entre 3 et 8 messages
        foreach ($discussions as $discussion) {
            MessageFactory::createMany(
                random_int(3, 8),
                [
                    'discussion' => $discussion,
                ]
            );
        }
    }
}
