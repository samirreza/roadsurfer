<?php

namespace App\Repository\Station;

use App\Entity\Station;

interface StationRepositoryInterface
{
    public function find(int $stationId): Station;
}

