<?php

namespace App\Request;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class RequestDTOValidationException extends Exception
{
    public function __construct(
        array $message = [],
        $code = Response::HTTP_UNPROCESSABLE_ENTITY,
        Exception $previous = null
    ) {
        parent::__construct(json_encode($message), $code, $previous);
    }
}
