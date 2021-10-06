<?php

namespace App\Query\Doctrine;

use App\Entity\Rent;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Query\UnresolvedOutputRentsQueryInterface;

final class DoctrineUnresolvedOutputRentsQuery implements UnresolvedOutputRentsQueryInterface
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
            ->addSelect('equipment')
            ->from(Rent::class, 'rent')
            ->innerJoin('rent.rentEquipments', 'rentEquipments')
            ->innerJoin('rentEquipments.equipment', 'equipment')
            ->where('rent.startStation = :startStation AND rent.deliverAt is null AND rent.startAt = :date')
            ->setParameters([
                'startStation' => $stationId,
                'date' => $date,
            ])
            ->getQuery()
            ->getResult();
    }
}
