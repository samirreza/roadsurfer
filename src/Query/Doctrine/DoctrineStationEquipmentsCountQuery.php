<?php

namespace App\Query\Doctrine;

use App\DTO\RentEquipmentDTO;
use App\Entity\StationEquipmentRelation;
use Doctrine\ORM\EntityManagerInterface;
use App\Query\StationEquipmentsCountQueryInterface;

class DoctrineStationEquipmentsCountQuery implements StationEquipmentsCountQueryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function execute(int $stationId): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $rows = $queryBuilder
            ->select('IDENTITY(ser.equipment) as equipmentId, ser.count')
            ->from(StationEquipmentRelation::class, 'ser')
            ->where('IDENTITY(ser.station) = :stationId')
            ->setParameters([
                'stationId' => $stationId,
            ])
            ->getQuery()
            ->getResult();

        $rentEquipmentDTOs = [];
        foreach ($rows as $row) {
            $rentEquipmentDTOs[] = new RentEquipmentDTO(
                $row['equipmentId'],
                $row['count']
            );
        }

        return $rentEquipmentDTOs;
    }
}
