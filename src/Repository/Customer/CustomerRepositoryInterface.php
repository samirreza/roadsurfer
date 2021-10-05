<?php

namespace App\Repository\Customer;

use App\Entity\User;

interface CustomerRepositoryInterface
{
    public function find(int $customerId): ?User;
}
