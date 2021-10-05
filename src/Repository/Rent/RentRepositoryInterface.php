<?php

namespace App\Repository\Rent;

use App\Entity\Rent;

interface RentRepositoryInterface
{
    public function find(int $rentId): ?Rent;

    public function add(Rent $rent): void;
}
