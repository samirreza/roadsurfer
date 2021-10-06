<?php

namespace App\Service\Station;

use DateTime;
use DateInterval;
use DateTimeInterface;
use App\DTO\EquipmentReportDTO;
use App\DTO\StationEquipmentDTO;
use App\Query\UnresolvedInputRentsQueryInterface;
use App\Query\UnresolvedOutputRentsQueryInterface;
use App\Repository\Equipment\EquipmentRepositoryInterface;
use App\Repository\StationEquipmentRelation\StationEquipmentRelationRepositoryInterface;

final class EquipmentReportGenerator
{
    public function __construct(
        private UnresolvedOutputRentsQueryInterface $unresolvedOutputRentsQuery,
        private UnresolvedInputRentsQueryInterface $unresolvedInputRentsQuery,
        private StationEquipmentsCalculator $stationEquipmentsCalculator,
        private StationEquipmentRelationRepositoryInterface $stationEquipmentRelationRepository,
        private EquipmentRepositoryInterface $equipmentRepository
    ) {
    }

    public function generate(int $stationId, DateTimeInterface $date): EquipmentReportDTO
    {
        return new EquipmentReportDTO(
            $this->getOutputEquipments($stationId, $date),
            $this->getInputEquipments($stationId, $date),
            $this->getAvailableEquipments($stationId, $date)
        );
    }

    private function getOutputEquipments(int $stationId, DateTimeInterface $date): array
    {
        $stationEquipmentDTO = [];
        $unresolvedOutputRents = $this->unresolvedOutputRentsQuery->execute($stationId, $date);
        foreach ($unresolvedOutputRents as $unresolvedOutputRent) {
            $rentEquipments = $unresolvedOutputRent->getRentEquipments();
            foreach ($rentEquipments as $rentEquipment) {
                $stationEquipmentDTO[] = new StationEquipmentDTO(
                    $rentEquipment->getEquipment()->getId(),
                    $rentEquipment->getEquipment()->getName(),
                    $rentEquipment->getCount()
                );
            }
        }

        return $stationEquipmentDTO;
    }

    private function getInputEquipments(int $stationId, DateTimeInterface $date): array
    {
        $stationEquipmentDTO = [];
        $unresolvedInputRents = $this->unresolvedInputRentsQuery->execute($stationId, $date);
        foreach ($unresolvedInputRents as $unresolvedInputRent) {
            $rentEquipments = $unresolvedInputRent->getRentEquipments();
            foreach ($rentEquipments as $rentEquipment) {
                $stationEquipmentDTO[] = new StationEquipmentDTO(
                    $rentEquipment->getEquipment()->getId(),
                    $rentEquipment->getEquipment()->getName(),
                    $rentEquipment->getCount()
                );
            }
        }

        return $stationEquipmentDTO;
    }

    private function getAvailableEquipments(int $stationId, DateTimeInterface $date): array
    {
        $includeTodayRents = true;
        if ($date == new DateTime(date('Y-m-d'))) {
            $includeTodayRents = false;
        }
        $oneDayBeforeDate = $date->sub(new DateInterval('P1D'));

        $rentEquipmentDTOs = $this->stationEquipmentsCalculator->calculate(
            $stationId,
            $oneDayBeforeDate,
            $oneDayBeforeDate,
            $includeTodayRents
        );

        $equipmentIds = [];
        foreach ($rentEquipmentDTOs as $rentEquipmentDTO) {
            $equipmentIds[] = $rentEquipmentDTO->getEquipmentId();
        }
        $equipments = $this->equipmentRepository->findByIds($equipmentIds);

        $stationEquipmentDTO = [];
        foreach ($equipments as $equipment) {
            foreach ($rentEquipmentDTOs as $rentEquipmentDTO) {
                if ($rentEquipmentDTO->getEquipmentId() == $equipment->getId()) {
                    $stationEquipmentDTO[] = new StationEquipmentDTO(
                        $equipment->getId(),
                        $equipment->getName(),
                        $rentEquipmentDTO->getCount()
                    );
                    break;
                }
            }
        }

        return $stationEquipmentDTO;
    }
}
