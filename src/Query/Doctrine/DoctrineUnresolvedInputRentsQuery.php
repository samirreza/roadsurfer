<?php

namespace App\Query\Doctrine;

use App\Entity\Rent;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Query\UnresolvedInputRentsQueryInterface;

final class DoctrineUnresolvedInputRentsQuery implements UnresolvedInputRentsQueryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function execute(int $stationId, DateTimeInterface $date): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        return $queryBuilder
            ->select('rent')
            ->addSelect('rentEquipments')
            ->from(Rent::class, 'rent')
            ->innerJoin('rent.rentEquipments', 'rentEquipments')
            ->where('rent.endStation = :endStation AND rent.getAt is null AND rent.endAt = :date')
            ->setParameters([
                'endStation' => $stationId,
                'date' => $date,
            ])
            ->getQuery()
            ->getResult();
    }
}

