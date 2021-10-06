<?php

namespace App\EventListener;

use App\Event\Rent\RentDeliveredEvent;
use App\Service\Station\StationEquipmentsCountManipulator;

class StationEquipmentsCountReducerListener
{
    public function __construct(private StationEquipmentsCountManipulator $stationEquipmentsCountManipulator)
    {
    }

    public function reduce(RentDeliveredEvent $event)
    {
        $this->stationEquipmentsCountManipulator->reduceByDeliveredRentId($event->getRentId());
    }
}

