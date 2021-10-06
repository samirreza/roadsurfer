<?php

namespace App\EventListener;

use App\Event\Rent\RentDeliveredEvent;
use App\Service\Station\StationEquipmentsCountReducer;

class StationEquipmentsCountReducerListener
{
    public function __construct(private StationEquipmentsCountReducer $stationEquipmentsCountReducer)
    {
    }

    public function reduce(RentDeliveredEvent $event)
    {
        $this->stationEquipmentsCountReducer->reduceByDeliveredRentId($event->getRentId());
    }
}

