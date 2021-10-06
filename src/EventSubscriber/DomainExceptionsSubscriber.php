<?php

namespace App\EventSubscriber;

use App\Exception\DomainExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use App\Service\Transaction\TransactionServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class DomainExceptionsSubscriber implements EventSubscriberInterface
{
    public function __construct(private TransactionServiceInterface $transactionService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['senResponse', 20],
        ];
    }

    public function senResponse(ExceptionEvent $event): void
    {
        if (!$event->getThrowable() instanceof DomainExceptionInterface) {
            return;
        }

        $response = new JsonResponse($event->getThrowable()->getMessage());
        $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $event->setResponse($response);
    }
}

