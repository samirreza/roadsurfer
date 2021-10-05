<?php

namespace App\Repository\Customer;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineCustomerRepository implements CustomerRepositoryInterface
{
    private $objectRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->objectRepository = $this->entityManager->getRepository(User::class);
    }

    public function find(int $customerId): ?User
    {
        return $this->objectRepository->find($customerId);
    }
}
