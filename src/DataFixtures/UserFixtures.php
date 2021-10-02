<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('amirreza.yeganegi@roadsurfer.de')
            ->setFirstName('Amirreza')
            ->setLastName('Yeganegi');
        $manager->persist($user);

        $user = new User();
        $user->setEmail('janina.fritze@roadsurfer.de')
            ->setFirstName('Janina')
            ->setLastName('Fritze');
        $manager->persist($user);

        $user = new User();
        $user->setEmail('robert.luht@roadsurfer.de')
            ->setFirstName('Robert')
            ->setLastName('Luht');
        $manager->persist($user);

        $manager->flush();
    }
}
