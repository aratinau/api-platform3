<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Note: désactiver le current user dans les DoctrineListener
        UserFactory::createSequence([
            [
                'email' => 'elise60@noos.fr',
                'firstName' => 'Elise',
                'lastName' => 'Noos',
            ],
            [
                'email' => 'bsmith@smith.fr',
                'firstName' => 'Bertrand',
                'lastName' => 'Smith',
            ],
        ]);

        UserFactory::createMany(200);

        $manager->flush();
    }
}
