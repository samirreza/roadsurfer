<?php

namespace App\EventListener;

use App\Exception\DomainExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class DomainExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        if (!$event->getThrowable() instanceof DomainExceptionInterface) {
            return;
        }

        $response = new JsonResponse($event->getThrowable()->getMessage());
        $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $event->setResponse($response);
    }
}
