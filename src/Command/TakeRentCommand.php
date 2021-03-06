<?php

namespace App\Command;

use DateTimeInterface;

class TakeRentCommand
{
    public function __construct(
        private int $rentId,
        private DateTimeInterface $getAt
    ) {
    }

    public function getRentId(): int
    {
        return $this->rentId;
    }

    public function getGetAt(): DateTimeInterface
    {
        return $this->getAt;
    }
}
