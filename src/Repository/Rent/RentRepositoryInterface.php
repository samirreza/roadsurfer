<?php

namespace App\Repository\Rent;

use App\Entity\Rent;

interface CityRepositoryInterface
{
    public function find(int $rentId): Rent;
}
