<?php

namespace App\DataFixtures;

use App\Factory\EquipmentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class EquipmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        EquipmentFactory::createMany(2);
        $manager->flush();
    }
}
