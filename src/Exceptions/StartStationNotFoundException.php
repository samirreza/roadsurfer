<?php

namespace App\Exceptions;

use InvalidArgumentException;

final class StartStationNotFoundException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Start station not found.');
    }
}
