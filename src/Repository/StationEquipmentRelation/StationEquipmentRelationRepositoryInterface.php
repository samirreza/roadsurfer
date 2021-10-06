<?php

namespace App\Repository\StationEquipmentRelation;

use App\Entity\StationEquipmentRelation;

interface StationEquipmentRelationRepositoryInterface
{
    public function findByStationIdAndEquipmentIds(
        int $stationId,
        array $equipmentIds
    ): array;

    public function add(StationEquipmentRelation $stationEquipmentRelation): void;
}
