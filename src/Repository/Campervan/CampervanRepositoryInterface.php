<?php

namespace App\Repository\Campervan;

use App\Entity\Campervan;

interface CampervanRepositoryInterface
{
    public function find(int $campervanId): Campervan;
}
