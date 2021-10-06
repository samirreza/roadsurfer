<?php

namespace App\Event;

interface ContainsEvents
{
    public function getRecordedEvents(): array;
    public function clearRecordedEvents(): void;
}
