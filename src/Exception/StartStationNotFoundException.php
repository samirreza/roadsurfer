<?php

namespace App\Exception;

use Exception;

final class StartStationNotFoundException extends Exception implements DomainExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Start station not found.');
    }
}
