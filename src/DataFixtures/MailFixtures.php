<?php

namespace App\DataFixtures;

use App\Factory\MailFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MailFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        MailFactory::createMany(200);
    }
}
