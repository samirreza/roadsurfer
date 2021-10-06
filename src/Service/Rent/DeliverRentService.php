<?php

namespace App\Service\Rent;

use App\Entity\Rent;
use App\Command\DeliverRentCommand;
use App\Exception\RentNotFoundException;
use App\Exception\RentAlreadyDeliveredException;
use App\Repository\Rent\RentRepositoryInterface;

final class DeliverRentService
{
    public function __construct(
        private RentRepositoryInterface $rentRepository
    ) {
    }

    public function deliver(DeliverRentCommand $deliverRentCommand)
    {
        $rent = $this->findRentOrFail($deliverRentCommand->getRentId());
        if ($rent->getDeliverAt()) {
            throw new RentAlreadyDeliveredException();
        }
        $rent->setDeliverAt($deliverRentCommand->getDeliverAt());
        $this->rentRepository->add($rent);
    }

    private function findRentOrFail(int $rentId): Rent
    {
        $rent = $this->rentRepository->find($rentId);
        if (!$rent) {
            throw new RentNotFoundException();
        }

        return $rent;
    }
}
