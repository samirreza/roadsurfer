<?php

namespace App\Exception;

use Exception;

final class EndStationNotFoundException extends Exception implements DomainExceptionInterface
{
    public function __construct()
    {
        parent::__construct('End station not found.');
    }
}
