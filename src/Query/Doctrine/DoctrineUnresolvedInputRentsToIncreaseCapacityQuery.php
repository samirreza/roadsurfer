<?php

namespace App\Query\Doctrine;

use App\Entity\Rent;
use DateTimeInterface;
use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;
use App\Query\UnresolvedInputRentsToIncreaseCapacityQueryInterface;

final class DoctrineUnresolvedInputRentsToIncreaseCapacityQuery implements UnresolvedInputRentsToIncreaseCapacityQueryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function execute(int $stationId, DateTimeInterface $bookStartAt, bool $includeTodayRents = true): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        return $queryBuilder
            ->select('rent')
            ->addSelect('rentEquipments')
            ->from(Rent::class, 'rent')
            ->innerJoin('rent.rentEquipments', 'rentEquipments')
            ->where('rent.endStation = :endStation AND rent.getAt is null')
            ->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->andX(
                        $queryBuilder->expr()->gt('rent.endAt', ':today'),
                        $queryBuilder->expr()->lte('rent.endAt', ':bookStartAt')
                    ),
                    date('H:i') < Station::END_TAKE_TIME && $includeTodayRents ? $queryBuilder->expr()->andX(
                        $queryBuilder->expr()->eq('rent.endAt', ':today')
                    ) : null
                )
            )
            ->setParameters([
                'endStation' => $stationId,
                'today' => date('Y-m-d'),
                'bookStartAt' => $bookStartAt,
            ])
            ->getQuery()
            ->getResult();
    }
}

