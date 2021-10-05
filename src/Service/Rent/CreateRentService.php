<?php

namespace App\Service\Rent;

use App\Entity\Rent;
use App\Entity\User;
use App\Entity\Station;
use App\Entity\Campervan;
use App\Command\CreateRentCommand;
use App\Exceptions\CustomerNotFoundException;
use App\Exceptions\CampervanNotFoundException;
use App\Exceptions\EndStationNotFoundException;
use App\Repository\Rent\RentRepositoryInterface;
use App\Exceptions\StartStationNotFoundException;
use App\Exceptions\RentEquipmentsNotValidException;
use App\Repository\Station\StationRepositoryInterface;
use App\Repository\Customer\CustomerRepositoryInterface;
use App\Repository\Campervan\CampervanRepositoryInterface;
use App\Repository\Equipment\EquipmentRepositoryInterface;

final class CreateRentService
{
    public function __construct(
        private StationRepositoryInterface $stationRepository,
        private CampervanRepositoryInterface $campervanRepository,
        private CustomerRepositoryInterface $customerRepository,
        private EquipmentRepositoryInterface $equipmentRepository,
        private RentRepositoryInterface $rentRepository,
        private RentEquipmentsValidator $rentEquipmentsValidator
    ) {
    }

    public function create(CreateRentCommand $createRentCommand): void
    {
        $startStation = $this->findStartStationOrFail($createRentCommand->getStartStationId());
        $endStation = $this->findEndStationOrFail($createRentCommand->getEndStationId());
        $campervan = $this->findCampervanOrFail($createRentCommand->getCampervanId());
        $customer = $this->findCustomerOrFail($createRentCommand->getCustomerId());

        $rent = new Rent(
            $startStation,
            $endStation,
            $createRentCommand->getStartAt(),
            $createRentCommand->getEndAt(),
            $campervan,
            $customer
        );

        if ($createRentCommand->getEquipments()) {
            $isEquipmentsValid = $this->rentEquipmentsValidator->isValid(
                $createRentCommand->getStartStationId(),
                $createRentCommand->getStartAt(),
                $createRentCommand->getEndAt(),
                $createRentCommand->getEquipments()
            );
            if (!$isEquipmentsValid) {
                throw new RentEquipmentsNotValidException();
            }
        }

        foreach ($createRentCommand->getEquipments() as $rentEquipmentDTO) {
            $equipment = $this->equipmentRepository->find($rentEquipmentDTO->getEquipmentId());
            if (!$equipment) {
                continue;
            }

            $rent->addRentEquipment(
                $equipment,
                $rentEquipmentDTO->getCount()
            );
        }

        $this->rentRepository->add($rent);
    }

    private function findStartStationOrFail(int $startStationId): Station
    {
        $startStation = $this->stationRepository->find($startStationId);
        if (!$startStation) {
            throw new EndStationNotFoundException();
        }

        return $startStation;
    }

    private function findEndStationOrFail(int $endStationId): Station
    {
        $endStation = $this->stationRepository->find($endStationId);
        if (!$endStation) {
            throw new StartStationNotFoundException();
        }

        return $endStation;
    }

    private function findCampervanOrFail(int $campervanId): Campervan
    {
        $campervan = $this->campervanRepository->find($campervanId);
        if (!$campervan) {
            throw new CampervanNotFoundException();
        }

        return $campervan;
    }

    private function findCustomerOrFail(int $customerId): User
    {
        $customer = $this->customerRepository->find($customerId);
        if (!$customer) {
            throw new CustomerNotFoundException();
        }

        return $customer;
    }
}
