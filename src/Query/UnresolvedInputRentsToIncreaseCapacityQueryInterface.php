<?php

namespace App\Query;

use DateTimeInterface;

interface UnresolvedInputRentsToIncreaseCapacityQueryInterface
{
    public function execute(int $stationId, DateTimeInterface $bookStartAt, bool $includeTodayRents = true): array;
}

