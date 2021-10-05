<?php

namespace App\Query;

use DateTimeInterface;

interface UnresolvedOutputRentsToReduceCapacityQueryInterface
{
    public function execute(int $stationId, DateTimeInterface $bookEndAt): array;
}
