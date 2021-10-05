<?php

namespace App\Request\Rent;

use DateTime;
use App\Entity\User;
use App\Entity\Station;
use App\DTO\RentEquipmentDTO;
use App\Validator\EntityExists;
use App\Request\RequestInterface;
use App\Command\CreateRentCommand;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateRentRequest implements RequestInterface
{
    public static function getConstraints(): array
    {
        return [
            new Assert\Collection([
                'fields' => [
                    'startStationId' => [
                        new Assert\Sequentially([
                            new Assert\NotBlank(),
                            new Assert\Type([
                                'type' => 'integer',
                            ]),
                            new EntityExists([
                                'entityClassName' => Station::class,
                                'message' => 'Start station does not exist.',
                            ]),
                        ]),
                    ],
                    'endStationId' => [
                        new Assert\Sequentially([
                            new Assert\NotBlank(),
                            new Assert\Type([
                                'type' => 'integer',
                            ]),
                            new EntityExists([
                                'entityClassName' => Station::class,
                                'message' => 'End station does not exist.',
                            ]),
                        ]),
                    ],
                    'campervanId' => [
                        new Assert\Sequentially([
                            new Assert\NotBlank(),
                            new Assert\Type([
                                'type' => 'integer',
                            ]),
                        ]),
                    ],
                    'customerId' => [
                        new Assert\Sequentially([
                            new Assert\NotBlank(),
                            new Assert\Type([
                                'type' => 'integer',
                            ]),
                            new EntityExists([
                                'entityClassName' => User::class,
                                'message' => 'Customer does not exist.',
                            ]),
                        ]),
                    ],
                    'startAt' => [
                        new Assert\Sequentially([
                            new Assert\NotBlank(),
                            new Assert\Date(),
                            new Assert\GreaterThanOrEqual([
                                'value' => '+1 day', //TODO: has bug
                            ]),
                        ]),
                    ],
                    'endAt' => [
                        new Assert\Sequentially([
                            new Assert\NotBlank(),
                            new Assert\Date(),
                            new Assert\GreaterThan([
                                'propertyPath' => 'startAt',
                            ]),
                        ]),
                    ],
                    'equipments' => [
                        new Assert\All([
                            new Assert\Collection([
                                'fields' => [
                                    'equipmentId' => [
                                        new Assert\Sequentially([
                                            new Assert\NotBlank(),
                                            new Assert\Type(['type' => 'integer']),
                                            new Assert\GreaterThanOrEqual([
                                                'value' => 1,
                                            ]),
                                        ]),
                                    ],
                                    'count' => [
                                        new Assert\Sequentially([
                                            new Assert\NotBlank(),
                                            new Assert\Type(['type' => 'integer']),
                                            new Assert\GreaterThanOrEqual([
                                                'value' => 1,
                                            ]),
                                        ]),
                                    ],
                                ],
                            ])
                        ]),
                    ],
                ],
            ])
        ];
    }

    public function __construct(
        private int $startStationId,
        private int $endStationId,
        private int $campervanId,
        private int $customerId,
        private string $startAt,
        private string $endAt,
        private array $equipments = []
    ) {
    }

    public function getStartStationId(): int
    {
        return $this->startStationId;
    }

    public function getEndStationId(): int
    {
        return $this->endStationId;
    }

    public function getCampervanId(): int
    {
        return $this->campervanId;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getStartAt(): string
    {
        return $this->startAt;
    }

    public function getEndAt(): string
    {
        return $this->endAt;
    }

    public function getEquipments(): array
    {
        return $this->equipments;
    }

    public function toCommand(): CreateRentCommand
    {
        $rentEquipmentDTOs = [];
        foreach ($this->equipments as $equipment) {
            $rentEquipmentDTOs[] = new RentEquipmentDTO(
                $equipment['equipmentId'],
                $equipment['count']
            );
        }

        return new CreateRentCommand(
            $this->startStationId,
            $this->endStationId,
            $this->campervanId,
            $this->customerId,
            DateTime::createFromFormat('Y-m-d', $this->startAt),
            DateTime::createFromFormat('Y-m-d', $this->endAt),
            $rentEquipmentDTOs
        );
    }
}
