<?php

namespace App\Exception;

use Exception;

final class CampervanNotFoundException extends Exception implements DomainExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Campervan not found.');
    }
}
