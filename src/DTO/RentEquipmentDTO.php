<?php

namespace App\DTO;

final class RentEquipmentDTO
{
    public function __construct(
        private int $equipmentId,
        private int $count
    ) {
    }

    public function getEquipmentId(): int
    {
        return $this->equipmentId;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
