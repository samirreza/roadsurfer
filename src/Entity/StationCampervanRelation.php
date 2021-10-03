<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class StationCampervanRelation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int  $id;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="stationCampervanRelations")
     * @ORM\JoinColumn(nullable=false)
     */
    private Station $station;

    /**
     * @ORM\ManyToOne(targetEntity=Campervan::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Campervan $campervan;

    /**
     * @ORM\Column(type="integer")
     */
    private int $count;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(Station $station): self
    {
        $this->station = $station;

        return $this;
    }

    public function getCampervan(): ?Campervan
    {
        return $this->campervan;
    }

    public function setCampervan(Campervan $campervan): self
    {
        $this->campervan = $campervan;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
