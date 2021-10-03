<?php

namespace App\Repository\Equipment;

use App\Entity\Equipment;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineEquipmentRepository implements EquipmentRepositoryInterface
{
    private $objectRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->objectRepository = $this->entityManager->getRepository(City::class);
    }

    public function find(int $equipmentId): Equipment
    {
        return $this->objectRepository->find($equipmentId);
    }
}
