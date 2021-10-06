<?php

namespace App\Service\Rent;

use App\Entity\Rent;
use App\Command\TakeRentCommand;
use App\Exception\RentNotFoundException;
use App\Exception\RentAlreadyTakenException;
use App\Repository\Rent\RentRepositoryInterface;

final class TakeRentService
{
    public function __construct(
        private RentRepositoryInterface $rentRepository
    ) {
    }

    public function take(TakeRentCommand $takeRentCommand)
    {
        $rent = $this->findRentOrFail($takeRentCommand->getRentId());
        $rent->setGetAt($takeRentCommand->getGetAt());
        $this->rentRepository->add($rent);
    }

    private function findRentOrFail(int $rentId): Rent
    {
        $rent = $this->rentRepository->find($rentId);
        if (!$rent) {
            throw new RentNotFoundException();
        }
        if ($rent->getGetAt()) {
            throw new RentAlreadyTakenException();
        }

        return $rent;
    }
}
