<?php

namespace App\DataFixtures;

use App\Factory\StationCampervanRelationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class StationCampervanRelationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        StationCampervanRelationFactory::new()->createMany(10);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            StationFixtures::class,
            CampervanFixtures::class,
        ];
    }
}
