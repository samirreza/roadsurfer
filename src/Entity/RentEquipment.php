<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class RentEquipment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Rent::class, inversedBy="rentEquipment")
     * @ORM\JoinColumn(nullable=false)
     */
    private Rent $rent;

    /**
     * @ORM\ManyToOne(targetEntity=Equipment::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Equipment $equipment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRent(): ?Rent
    {
        return $this->rent;
    }

    public function setRent(Rent $rent): self
    {
        $this->rent = $rent;

        return $this;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }
}
