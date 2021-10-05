<?php

namespace App\Repository\User;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function find(int $userId): ?User;
}
