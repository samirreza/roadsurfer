<?php

namespace App\Tests;

use DateTime;
use DateInterval;
use App\Entity\Rent;
use App\Factory\CityFactory;
use App\Factory\UserFactory;
use App\DTO\RentEquipmentDTO;
use App\Factory\StationFactory;
use App\Factory\CampervanFactory;
use App\Factory\EquipmentFactory;
use App\Service\Rent\RentEquipmentsValidator;
use App\Factory\StationEquipmentRelationFactory;

class RentEquipmentsValidatorTest extends BaseKernelTestCase
{
    private $entityManager;
    private $stations;
    private $equipments;

    protected function setUp(): void
    {
        parent::setUp();

        $this->entityManager = self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->addInitializeData();
    }

    public function test_validation_faild_because_count_is_more_than_capacity(): void
    {
        $container = static::getContainer();
        $rentEquipmentsValidator = $container->get(RentEquipmentsValidator::class);
        $isValid = $rentEquipmentsValidator->isValid(
            $this->stations[0]->getId(),
            (new DateTime())->add(new DateInterval('P1D')),
            (new DateTime())->add(new DateInterval('P6D')),
            [
                new RentEquipmentDTO($this->equipments[0]->getId(), 3),
            ]
        );
        $this->assertFalse($isValid);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }

    private function addInitializeData()
    {
        $user = UserFactory::createOne();
        CityFactory::createOne();
        $this->stations = StationFactory::createMany(2);
        $campervan = CampervanFactory::createOne();
        $this->equipments = EquipmentFactory::createMany(2);
        StationEquipmentRelationFactory::createOne([
            'station' => $this->stations[0],
            'equipment' => $this->equipments[0],
            'count' => 4,
        ]);
        StationEquipmentRelationFactory::createOne([
            'station' => $this->stations[0],
            'equipment' => $this->equipments[1],
            'count' => 2,
        ]);
        StationEquipmentRelationFactory::createOne([
            'station' => $this->stations[1],
            'equipment' => $this->equipments[0],
            'count' => 1,
        ]);
        StationEquipmentRelationFactory::createOne([
            'station' => $this->stations[1],
            'equipment' => $this->equipments[1],
            'count' => 3,
        ]);

        $rent = new Rent(
            $this->stations[0]->object(),
            $this->stations[1]->object(),
            (new DateTime())->add(new DateInterval('P1D')),
            (new DateTime())->add(new DateInterval('P4D')),
            $campervan->object(),
            $user->object(),
        );
        $rent->addRentEquipment(
            $this->equipments[0]->object(),
            2
        );
        $this->entityManager->persist($rent);
        $this->entityManager->flush();
    }
}
