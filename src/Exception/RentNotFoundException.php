<?php

namespace App\Exception;

use Exception;

final class RentNotFoundException extends Exception implements DomainExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Rent not found.');
    }
}
