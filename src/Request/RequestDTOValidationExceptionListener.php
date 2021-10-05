<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class RequestDTOValidationExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        if (!$event->getThrowable() instanceof RequestDTOValidationException) {
            return;
        }

        $response = new JsonResponse(
            json_decode($event->getThrowable()->getMessage())
        );
        $response->setStatusCode($event->getThrowable()->getCode());
        $event->setResponse($response);
    }
}
