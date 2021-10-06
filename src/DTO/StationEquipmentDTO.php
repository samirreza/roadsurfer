<?php

namespace App\DTO;

final class StationEquipmentDTO
{
    public function __construct(
        private int $equipmentId,
        private string $equipmentName,
        private int $count
    ) {
    }

    public function getEquipmentId(): int
    {
        return $this->equipmentId;
    }

    public function getEquipmentName(): string
    {
        return $this->equipmentName;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}

