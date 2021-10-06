<?php

namespace App\Query;

use DateTimeInterface;

interface UnresolvedInputRentsQueryInterface
{
    public function execute(int $stationId, DateTimeInterface $date): array;
}

