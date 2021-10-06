<?php

namespace App\Query;

use DateTimeInterface;

interface UnresolvedOutputRentsQueryInterface
{
    public function execute(int $stationId, DateTimeInterface $date): array;
}
