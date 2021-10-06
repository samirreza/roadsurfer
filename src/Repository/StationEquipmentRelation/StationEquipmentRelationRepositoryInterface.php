<?php

namespace App\Repository\StationEquipmentRelation;

interface StationEquipmentRelationRepositoryInterface
{
    public function findByStationIdAndEquipmentIds(
        int $stationId,
        array $equipmentIds
    ): array;
}
