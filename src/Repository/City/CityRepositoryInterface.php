<?php

namespace App\Repository\City;

use App\Entity\City;

interface CityRepositoryInterface
{
    public function find(int $cityId): City;
}
