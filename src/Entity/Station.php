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

    public function __construct()
    {
        $this->stationCampervanRelations = new ArrayCollection();
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

    public function removeStationCampervanRelation(StationCampervanRelation $stationCampervanRelation): self
    {
        if ($this->stationCampervanRelations->removeElement($stationCampervanRelation)) {
            if ($stationCampervanRelation->getStation() === $this) {
                $stationCampervanRelation->setStation(null);
            }
        }

        return $this;
    }
}
