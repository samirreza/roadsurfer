<?php

namespace App\Command;

use DateTimeInterface;

class CreateRentCommand
{
    public function __construct(
        private int $startStationId,
        private int $endStationId,
        private int $campervanId,
        private int $customerId,
        private DateTimeInterface $startAt,
        private DateTimeInterface $endAt,
        private array $equipments
    ) {
    }

    public function getStartStationId(): int
    {
        return $this->startStationId;
    }

    public function getEndStationId(): int
    {
        return $this->endStationId;
    }

    public function getCampervanId(): int
    {
        return $this->campervanId;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getStartAt(): DateTimeInterface
    {
        return $this->startAt;
    }

    public function getEndAt(): DateTimeInterface
    {
        return $this->endAt;
    }

    public function getEquipments(): array
    {
        return $this->equipments;
    }
}
