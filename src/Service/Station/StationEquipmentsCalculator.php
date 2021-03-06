<?php

namespace App\Service\Station;

use DateTimeInterface;
use App\DTO\RentEquipmentDTO;
use App\Query\StationEquipmentsCountQueryInterface;
use App\Query\UnresolvedOutputRentsToReduceCapacityQueryInterface;
use App\Query\UnresolvedInputRentsToIncreaseCapacityQueryInterface;

final class StationEquipmentsCalculator
{
    public function __construct(
        private StationEquipmentsCountQueryInterface $stationEquipmentsCountQuery,
        private UnresolvedOutputRentsToReduceCapacityQueryInterface $unresolvedOutputRentsToReduceCapacityQuery,
        private UnresolvedInputRentsToIncreaseCapacityQueryInterface $unresolvedInputRentsToIncreaseCapacityQuery
    ) {
    }

    public function calculate(
        int $stationId,
        DateTimeInterface $bookStartAt,
        DateTimeInterface $bookEndAt,
        bool $includeTodayRents = true
    ): array {
        $currentStateMapping = $this->getMappingForCurrentState($stationId);
        $reductionMapping = $this->getMappingForReduction($stationId, $bookEndAt, $includeTodayRents);
        $increaseMapping = $this->getMappingForIncrease($stationId, $bookStartAt, $includeTodayRents);

        $rentEquipmentDTOs = [];
        foreach (array_keys($currentStateMapping + $reductionMapping + $increaseMapping) as $key) {
            $sum = ($currentStateMapping[$key] ?? 0) - ($reductionMapping[$key] ?? 0) + ($increaseMapping[$key] ?? 0);
            if ($sum >= 1) {
                $rentEquipmentDTOs[] = new RentEquipmentDTO(
                    $key,
                    $sum
                );
            }
        }

        return $rentEquipmentDTOs;
    }

    public function getMappingForCurrentState(int $stationId): array
    {
        $currentStateMapping = [];
        $rentEquipmentDTOs = $this->stationEquipmentsCountQuery->execute($stationId);
        foreach ($rentEquipmentDTOs as $rentEquipmentDTO) {
            $currentStateMapping[$rentEquipmentDTO->getEquipmentId()] = $rentEquipmentDTO->getCount();
        }

        return $currentStateMapping;
    }

    private function getMappingForReduction(int $stationId, DateTimeInterface $bookEndAt, bool $includeTodayRents): array
    {
        $reductionMapping = [];
        $rents = $this->unresolvedOutputRentsToReduceCapacityQuery->execute($stationId, $bookEndAt, $includeTodayRents);
        foreach ($rents as $rent) {
            $rentEquipments = $rent->getRentEquipments();
            foreach ($rentEquipments as $rentEquipment) {
                if (isset($reductionMapping[$rentEquipment->getEquipment()->getId()])) {
                    $reductionMapping[$rentEquipment->getEquipment()->getId()]+= $rentEquipment->getCount();
                } else {
                    $reductionMapping[$rentEquipment->getEquipment()->getId()] = $rentEquipment->getCount();
                }
            }
        }

        return $reductionMapping;
    }

    private function getMappingForIncrease(int $stationId, DateTimeInterface $bookStartAt, bool $includeTodayRents): array
    {
        $increaseMapping = [];
        $rents = $this->unresolvedInputRentsToIncreaseCapacityQuery->execute($stationId, $bookStartAt, $includeTodayRents);
        foreach ($rents as $rent) {
            $rentEquipments = $rent->getRentEquipments();
            foreach ($rentEquipments as $rentEquipment) {
                if (isset($increaseMapping[$rentEquipment->getEquipment()->getId()])) {
                    $increaseMapping[$rentEquipment->getEquipment()->getId()]+= $rentEquipment->getCount();
                } else {
                    $increaseMapping[$rentEquipment->getEquipment()->getId()] = $rentEquipment->getCount();
                }
            }
        }

        return $increaseMapping;
    }
}
