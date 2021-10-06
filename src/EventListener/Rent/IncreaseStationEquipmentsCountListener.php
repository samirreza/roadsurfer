<?php

namespace App\EventListener;

use App\Event\Rent\RentTakenEvent;
use App\Service\Station\StationEquipmentsCountReducer;

class IncreaseStationEquipmentsCountListener
{
    public function __construct(private StationEquipmentsCountReducer $stationEquipmentsCountReducer)
    {
    }

    public function increase(RentTakenEvent $event)
    {
        $this->stationEquipmentsCountReducer->increaseByDeliveredRentId($event->getRentId());
    }
}

