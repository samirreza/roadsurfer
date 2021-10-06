<?php

namespace App\Service\Station;

use App\Entity\Rent;
use App\Entity\Station;
use App\Entity\Equipment;
use App\Entity\StationEquipmentRelation;
use App\Exception\RentNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Rent\RentRepositoryInterface;
use App\Repository\StationEquipmentRelation\StationEquipmentRelationRepositoryInterface;

final class StationEquipmentsCountManipulator
{
    public function __construct(
        private RentRepositoryInterface $rentRepository,
        private StationEquipmentRelationRepositoryInterface $stationEquipmentRelationRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function reduceByDeliveredRentId(int $rentId)
    {
        $rent = $this->findRentOrFail($rentId);
        $mapping = $this->getRentEquipmentCountMapping($rent);
        if (!$mapping) {
            return;
        }
        $stationEquipmentRelations = $this->findStartStationEquipmentRelations(
            $rent,
            $mapping
        );
        $this->reduceCount($stationEquipmentRelations, $mapping);
    }

    public function increaseByDeliveredRentId(int $rentId)
    {
        $rent = $this->findRentOrFail($rentId);
        $mapping = $this->getRentEquipmentCountMapping($rent);
        if (!$mapping) {
            return;
        }
        $stationEquipmentRelations = $this->findEndStationEquipmentRelations(
            $rent,
            $mapping
        );
        $this->increaseCount(
            $stationEquipmentRelations,
            $mapping,
            $rent->getEndStation()->getId()
        );
    }

    private function getRentEquipmentCountMapping(Rent $rent): array
    {
        $mapping = [];
        foreach ($rent->getRentEquipments() as $rentEquipment) {
            $mapping[$rentEquipment->getEquipment()->getId()] = $rentEquipment->getCount();
        }

        return $mapping;
    }

    private function findRentOrFail(int $rentId): Rent
    {
        $rent = $this->rentRepository->find($rentId);
        if (!$rent || !$rent->getDeliverAt()) {
            throw new RentNotFoundException();
        }

        return $rent;
    }

    private function findStartStationEquipmentRelations(Rent $rent, array $mapping): array
    {
        $equipmentIds = array_keys($mapping);

        return $this->stationEquipmentRelationRepository
            ->findByStationIdAndEquipmentIds(
                $rent->getStartStation()->getId(),
                $equipmentIds
            );
    }

    private function reduceCount(array $stationEquipmentRelations, array $mapping): void
    {
        foreach ($stationEquipmentRelations as $stationEquipmentRelation) {
            $stationEquipmentRelation->reduceCount(
                $mapping[$stationEquipmentRelation->getEquipment()->getId()]
            );
        }
    }

    private function findEndStationEquipmentRelations(Rent $rent, array $mapping): array
    {
        $equipmentIds = array_keys($mapping);

        return $this->stationEquipmentRelationRepository
            ->findByStationIdAndEquipmentIds(
                $rent->getEndStation()->getId(),
                $equipmentIds
            );
    }

    private function increaseCount(array $stationEquipmentRelations, array $mapping, int $endStationId): void
    {
        foreach ($stationEquipmentRelations as $stationEquipmentRelation) {
            $stationEquipmentRelation->increaseCount(
                $mapping[$stationEquipmentRelation->getEquipment()->getId()]
            );
            unset($mapping[$stationEquipmentRelation->getEquipment()->getId()]);
        }
        foreach ($mapping as $equipmentId => $count) {
            $stationEquipmentRelation = new StationEquipmentRelation(
                $this->entityManager->getReference(Station::class, $endStationId),
                $this->entityManager->getReference(Equipment::class, $equipmentId),
                $count
            );
            $this->stationEquipmentRelationRepository->add($stationEquipmentRelation);
        }
    }
}
