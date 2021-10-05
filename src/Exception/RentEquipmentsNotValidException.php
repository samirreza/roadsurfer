<?php

namespace App\Exception;

use Exception;

final class RentEquipmentsNotValidException extends Exception implements DomainExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Rent equipments not valid.');
    }
}
