<?php

namespace App\Exception;

use Exception;

final class RentAlreadyTakenException extends Exception implements DomainExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Rent already taken.');
    }
}
