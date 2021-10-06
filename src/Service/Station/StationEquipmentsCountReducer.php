<?php

namespace App\Service\Station;

use App\Entity\Rent;
use App\Exception\RentNotFoundException;
use App\Repository\Rent\RentRepositoryInterface;
use App\Repository\StationEquipmentRelation\StationEquipmentRelationRepositoryInterface;

final class StationEquipmentsCountReducer
{
    public function __construct(
        private RentRepositoryInterface $rentRepository,
        private StationEquipmentRelationRepositoryInterface $stationEquipmentRelationRepository
    ) {
    }

    public function reduceByDeliveredRentId(int $rentId)
    {
        $this->manipulate($rentId, true);
    }

    public function increaseByDeliveredRentId(int $rentId)
    {
        $this->manipulate($rentId, false);
    }

    private function manipulate(int $rentId, bool $reduce): void
    {
        $rent = $this->findRentOrFail($rentId);
        $mapping = $this->getRentEquipmentCountMapping($rent);
        if (!$mapping) {
            return;
        }
        $stationEquipmentRelations = $this->findStationEquipmentRelations(
            $rent,
            $mapping
        );
        if ($reduce) {
            $this->reduceCount($stationEquipmentRelations, $mapping);
        } else {
            $this->increaseCount($stationEquipmentRelations, $mapping);
        }
    }

    private function getRentEquipmentCountMapping(Rent $rent): array
    {
        $mapping = [];
        if (!$rent->getRentEquipments()->isEmpty()) {
            foreach ($rent->getRentEquipments() as $rentEquipment) {
                $mapping[$rentEquipment->getEquipment()->getId()] = $rentEquipment->getCount();
            }
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

    private function findStationEquipmentRelations(Rent $rent, array $mapping): array
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

    private function increaseCount(array $stationEquipmentRelations, array $mapping): void
    {
        foreach ($stationEquipmentRelations as $stationEquipmentRelation) {
            $stationEquipmentRelation->increaseCount(
                $mapping[$stationEquipmentRelation->getEquipment()->getId()]
            );
        }
    }
}
