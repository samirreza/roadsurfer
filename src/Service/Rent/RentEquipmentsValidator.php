<?php

namespace App\Service\Rent;

use DateTimeInterface;

final class RentEquipmentsValidator
{
    public function __construct(
        private StationEquipmentsCalculator $stationEquipmentsCalculator
    ) {
    }

    public function isValid(
        int $stationId,
        DateTimeInterface $startAt,
        DateTimeInterface $endAt,
        array $orderedEquipments
    ): bool {
        $allowedEquipmentsByCount = $this->reIndex(
            $this->stationEquipmentsCalculator->calculate(
                $stationId,
                $startAt,
                $endAt
            )
        );

        foreach ($orderedEquipments as $orderedEquipment) {
            if (!isset($allowedEquipmentsByCount[$orderedEquipment->getEquipmentId()])) {
                return false;
            }

            if ($orderedEquipment->getCount() > $allowedEquipmentsByCount[$orderedEquipment->getEquipmentId()]) {
                return false;
            }
        }

        return true;
    }

    private function reIndex(array $rentEquipmentDTOs): array
    {
        $result = [];
        foreach ($rentEquipmentDTOs as $rentEquipmentDTO) {
            $result[$rentEquipmentDTO->getEquipmentId()] = $rentEquipmentDTO->getCount();
        }

        return $result;
    }
}
