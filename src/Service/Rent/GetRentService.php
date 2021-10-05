<?php

namespace App\Service\Rent;

use App\Entity\Rent;
use App\Command\GetRentCommand;
use App\Exception\RentNotFoundException;
use App\Exception\RentAlreadyTakenException;
use App\Repository\Rent\RentRepositoryInterface;

class GetRentService
{
    public function __construct(
        private RentRepositoryInterface $rentRepository
    ) {
    }

    public function deliver(GetRentCommand $getRentCommand)
    {
        $rent = $this->findRentOrFail($getRentCommand->getRentId());
        if ($rent->getGetAt()) {
            throw new RentAlreadyTakenException();
        }
        $rent->setGetAt($getRentCommand->getGetAt());
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
