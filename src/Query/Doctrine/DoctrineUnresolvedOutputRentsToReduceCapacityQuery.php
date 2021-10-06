<?php

namespace App\Query\Doctrine;

use App\Entity\Rent;
use DateTimeInterface;
use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;
use App\Query\UnresolvedOutputRentsToReduceCapacityQueryInterface;

final class DoctrineUnresolvedOutputRentsToReduceCapacityQuery implements UnresolvedOutputRentsToReduceCapacityQueryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function execute(int $stationId, DateTimeInterface $bookEndAt, bool $includeTodayRents = true): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        return $queryBuilder
            ->select('rent')
            ->addSelect('rentEquipments')
            ->from(Rent::class, 'rent')
            ->innerJoin('rent.rentEquipments', 'rentEquipments')
            ->where('rent.startStation = :startStation AND rent.deliverAt is null')
            ->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->andX(
                        $queryBuilder->expr()->gt('rent.startAt', ':today'),
                        $queryBuilder->expr()->lt('rent.startAt', ':bookEndAt')
                    ),
                    date('H:i') < Station::END_DELIVERY_TIME && $includeTodayRents ? $queryBuilder->expr()->andX(
                        $queryBuilder->expr()->eq('rent.startAt', ':today')
                    ) : null
                )
            )
            ->setParameters([
                'startStation' => $stationId,
                'today' => date('Y-m-d'),
                'bookEndAt' => $bookEndAt,
            ])
            ->getQuery()
            ->getResult();
    }
}
