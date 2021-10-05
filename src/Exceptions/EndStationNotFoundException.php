<?php

namespace App\Exceptions;

use InvalidArgumentException;

final class EndStationNotFoundException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('End station not found.');
    }
}
