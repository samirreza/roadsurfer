<?php

namespace App\Exceptions;

use InvalidArgumentException;

final class CampervanNotFoundException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Campervan not found.');
    }
}
