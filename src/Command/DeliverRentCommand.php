<?php

namespace App\Command;

use DateTimeInterface;

class DeliverRentCommand
{
    public function __construct(
        private int $rentId,
        private DateTimeInterface $deliverAt
    ) {
    }

    public function getRentId(): int
    {
        return $this->rentId;
    }

    public function getDeliverAt(): DateTimeInterface
    {
        return $this->deliverAt;
    }
}
