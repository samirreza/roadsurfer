<?php

namespace App\Repository\StationEquipmentRelation;

use App\Entity\StationEquipmentRelation;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineStationEquipmentRelationRepository implements StationEquipmentRelationRepositoryInterface
{
    private $objectRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->objectRepository = $this->entityManager->getRepository(StationEquipmentRelation::class);
    }

    public function findByStationIdAndEquipmentIds(
        int $stationId,
        array $equipmentIds
    ): array {
        return $this->objectRepository->findBy([
            'station' => $stationId,
            'equipment' => $equipmentIds,
        ]);
    }
}
