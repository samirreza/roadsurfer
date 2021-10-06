<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use App\Service\Transaction\TransactionServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class ManageTransactionForRequestSubscriber implements EventSubscriberInterface
{
    public function __construct(private TransactionServiceInterface $transactionService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => ['startTransaction', 10],
            KernelEvents::RESPONSE => ['commitTransaction', 10],
            KernelEvents::EXCEPTION => ['rollbackTransaction', 11],
        ];
    }

    public function startTransaction(): void
    {
        $this->transactionService->start();
    }

    public function commitTransaction(): void
    {
        $this->transactionService->commit();
    }

    public function rollbackTransaction(): void
    {
        $this->transactionService->rollback();
    }
}
