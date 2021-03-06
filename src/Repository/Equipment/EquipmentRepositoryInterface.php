<?php

namespace App\Repository\Equipment;

use App\Entity\Equipment;

interface EquipmentRepositoryInterface
{
    public function find(int $equipmentId): ?Equipment;

    public function findByIds(array $equipmentIds): array;
}
