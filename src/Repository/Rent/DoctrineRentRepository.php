<?php

namespace App\Repository\Rent;

use App\Entity\Rent;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineRentRepository implements CityRepositoryInterface
{
    private $objectRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->objectRepository = $this->entityManager->getRepository(Rent::class);
    }

    public function find(int $rentId): Rent
    {
        return $this->objectRepository->find($rentId);
    }
}
