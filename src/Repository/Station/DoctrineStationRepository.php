<?php

namespace App\Repository\Station;

use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineStationRepository implements StationRepositoryInterface
{
    private $objectRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->objectRepository = $this->entityManager->getRepository(Station::class);
    }

    public function find(int $stationId): ?Station
    {
        return $this->objectRepository->find($stationId);
    }
}
