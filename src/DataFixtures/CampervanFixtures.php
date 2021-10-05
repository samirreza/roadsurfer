<?php

namespace App\DataFixtures;

use App\Factory\CampervanFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class CampervanFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CampervanFactory::new()->createMany(5);
        $manager->flush();
    }
}
