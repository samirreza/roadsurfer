<?php

namespace App\DataFixtures;

use App\Factory\StationEquipmentRelationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class StationEquipmentRelationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        StationEquipmentRelationFactory::new()->createMany(20);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            StationFixtures::class,
            EquipmentFixtures::class,
        ];
    }
}
