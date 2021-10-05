<?php

namespace App\Query;

interface StationEquipmentsCountQueryInterface
{
    public function execute(int $stationId): array;
}
