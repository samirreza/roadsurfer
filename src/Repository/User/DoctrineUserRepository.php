<?php

namespace App\Repository\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineUserRepository implements UserRepositoryInterface
{
    private $objectRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->objectRepository = $this->entityManager->getRepository(User::class);
    }

    public function find(int $userId): ?User
    {
        return $this->objectRepository->find($userId);
    }
}
