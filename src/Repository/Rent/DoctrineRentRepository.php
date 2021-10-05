<?php

namespace App\Repository\Rent;

use App\Entity\Rent;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineRentRepository implements RentRepositoryInterface
{
    private $objectRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->objectRepository = $this->entityManager->getRepository(Rent::class);
    }

    public function find(int $rentId): ?Rent
    {
        return $this->objectRepository->find($rentId);
    }

    public function add(Rent $rent): void
    {
        $this->entityManager->persist($rent);
    }
}
