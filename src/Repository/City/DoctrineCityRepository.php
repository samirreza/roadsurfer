<?php

namespace App\Repository\City;

use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineCityRepository implements CityRepositoryInterface
{
    private $objectRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->objectRepository = $this->entityManager->getRepository(City::class);
    }

    public function find(int $cityId): City
    {
        return $this->objectRepository->find($cityId);
    }
}
