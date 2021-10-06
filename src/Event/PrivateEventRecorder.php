<?php

namespace App\Event;

trait PrivateEventRecorder
{
    private $messages = [];

    public function getRecordedEvents(): array
    {
        return $this->messages;
    }

    public function clearRecordedEvents(): void
    {
        $this->messages = [];
    }

    public function record($message): void
    {
        $this->messages[] = $message;
    }
}
