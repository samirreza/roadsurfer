<?php

namespace App\Exceptions;

use InvalidArgumentException;

final class CustomerNotFoundException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Customer not found.');
    }
}
