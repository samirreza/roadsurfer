<?php

namespace App\Event\Rent;

use Symfony\Contracts\EventDispatcher\Event;

final class RentTakenEvent extends Event
{
    public function __construct(private int $rentId)
    {
    }

    public function getRentId(): int
    {
        return $this->rentId;
    }
}

