<?php

namespace App\Exceptions;

use InvalidArgumentException;

final class RentEquipmentsNotValidException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Rent equipments not valid.');
    }
}
