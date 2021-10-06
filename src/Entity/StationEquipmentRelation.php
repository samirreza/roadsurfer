<?php

namespace App\Entity;

use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class StationEquipmentRelation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="stationEquipmentRelations")
     * @ORM\JoinColumn(nullable=false)
     */
    private Station $station;

    /**
     * @ORM\ManyToOne(targetEntity=Equipment::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Equipment $equipment;

    /**
     * @ORM\Column(type="integer")
     */
    private int $count;

    public function __construct(
        Station $station,
        Equipment $equipment,
        int $count
    ) {
        $this->station = $station;
        $this->equipment = $equipment;
        $this->count = $count;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStation(): Station
    {
        return $this->station;
    }

    public function setStation(Station $station): self
    {
        $this->station = $station;

        return $this;
    }

    public function getEquipment(): Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function reduceCount(int $count): self
    {
        Assertion::lessOrEqualThan($count, $this->count, 'Count con not be negative.');
        $this->count -= $count;

        return $this;
    }

    public function increaseCount(int $count): self
    {
        $this->count += $count;

        return $this;
    }
}
