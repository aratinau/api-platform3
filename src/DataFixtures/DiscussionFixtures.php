<?php

namespace App\DataFixtures;

use App\Entity\Discussion\Discussion;
use App\Factory\Discussion\DiscussionFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DiscussionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        DiscussionFactory::createMany(50, [
            'author' => UserFactory::random(),
        ]);
    }
}
