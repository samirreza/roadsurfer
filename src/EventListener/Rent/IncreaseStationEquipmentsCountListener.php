<?php

namespace App\EventListener\Rent;

use App\Event\Rent\RentTakenEvent;
use App\Service\Station\StationEquipmentsCountManipulator;

class IncreaseStationEquipmentsCountListener
{
    public function __construct(private StationEquipmentsCountManipulator $stationEquipmentsCountManipulator)
    {
    }

    public function increase(RentTakenEvent $event)
    {
        $this->stationEquipmentsCountManipulator->increaseByDeliveredRentId($event->getRentId());
    }
}

