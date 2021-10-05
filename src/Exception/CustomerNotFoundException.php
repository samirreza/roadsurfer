<?php

namespace App\Exception;

use Exception;

final class CustomerNotFoundException extends Exception implements DomainExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Customer not found.');
    }
}
