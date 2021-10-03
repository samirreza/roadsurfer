<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Station
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity=City::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private City $city;

    /**
     * @ORM\OneToMany(targetEntity=StationCampervanRelation::class, mappedBy="station", orphanRemoval=true)
     */
    private $stationCampervanRelations;

    /**
     * @ORM\OneToMany(targetEntity=StationEquipmentRelation::class, mappedBy="station", orphanRemoval=true)
     */
    private $stationEquipmentRelations;

    /**
     * @ORM\OneToMany(targetEntity=Rent::class, mappedBy="startStation", orphanRemoval=true)
     */
    private $rents;

    public function __construct()
    {
        $this->stationCampervanRelations = new ArrayCollection();
        $this->stationEquipmentRelations = new ArrayCollection();
        $this->rents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStationCampervanRelations(): Collection
    {
        return $this->stationCampervanRelations;
    }

    public function addStationCampervanRelation(StationCampervanRelation $stationCampervanRelation): self
    {
        if (!$this->stationCampervanRelations->contains($stationCampervanRelation)) {
            $this->stationCampervanRelations[] = $stationCampervanRelation;
            $stationCampervanRelation->setStation($this);
        }

        return $this;
    }

    public function getStationEquipmentRelations(): Collection
    {
        return $this->stationEquipmentRelations;
    }

    public function addStationEquipmentRelation(StationEquipmentRelation $stationEquipmentRelation): self
    {
        if (!$this->stationEquipmentRelations->contains($stationEquipmentRelation)) {
            $this->stationEquipmentRelations[] = $stationEquipmentRelation;
            $stationEquipmentRelation->setStation($this);
        }

        return $this;
    }

    public function getRents(): Collection
    {
        return $this->rents;
    }
}
