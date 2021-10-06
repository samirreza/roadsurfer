<?php

namespace App\Event;

interface RecordsEvents
{
    public function record($event): void;
}
