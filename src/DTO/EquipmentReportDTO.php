<?php

namespace App\DTO;

class EquipmentReportDTO
{
    public function __construct(
        private array $outputEquipments,
        private array $inputEquipments,
        private array $availableEquipments
    )
    {
    }

    public function getOutputEquipments(): array
    {
        return $this->outputEquipments;
    }

    public function getInputEquipments(): array
    {
        return $this->inputEquipments;
    }

    public function getAvailableEquipments(): array
    {
            return $this->availableEquipments;
    }
}
