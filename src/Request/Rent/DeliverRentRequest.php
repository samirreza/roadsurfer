<?php

namespace App\Request\Rent;

use DateTime;
use App\Entity\Rent;
use App\Validator\EntityExists;
use App\Request\RequestInterface;
use App\Command\DeliverRentCommand;
use Symfony\Component\Validator\Constraints as Assert;

class DeliverRentRequest implements RequestInterface
{
    public static function getConstraints(): array
    {
        return [
            new Assert\NotBlank(),
            new Assert\Collection([
                'fields' => [
                    'rentId' => [
                        new Assert\Sequentially([
                            new Assert\NotBlank(),
                            new Assert\Type([
                                'type' => 'integer',
                            ]),
                            new EntityExists([
                                'entityClassName' => Rent::class,
                                'message' => 'Rent does not exist.',
                            ]),
                        ]),
                    ],
                ],
            ])
        ];
    }

    public function __construct(private int $rentId)
    {
    }

    public function getRentId(): int
    {
        return $this->rentId;
    }

    public function toCommand(): DeliverRentCommand
    {
        return new DeliverRentCommand(
            $this->rentId,
            DateTime::createFromFormat('Y-m-d', date('Y-m-d'))
        );
    }
}
