<?php

namespace App\DataFixtures;

use App\Factory\EquipmentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class EquipmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        EquipmentFactory::new()->createMany(10);
        $manager->flush();
    }
}
