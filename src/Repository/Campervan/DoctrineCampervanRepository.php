<?php

namespace App\Repository\Campervan;

use App\Entity\Campervan;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineCampervanRepository implements CampervanRepositoryInterface
{
    private $objectRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->objectRepository = $this->entityManager->getRepository(Campervan::class);
    }

    public function find(int $campervanId): Campervan
    {
        return $this->objectRepository->find($campervanId);
    }
}
