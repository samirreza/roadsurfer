<?php

namespace App\DataFixtures;

use App\Factory\CityFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CityFactory::createMany(2);
        $manager->flush();
    }
}
