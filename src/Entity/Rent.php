<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 */
class Rent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="rents")
     * @ORM\JoinColumn(nullable=false)
     */
    private Station $startStation;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="rents")
     * @ORM\JoinColumn(nullable=false)
     */
    private Station $endStation;

    /**
     * @ORM\Column(type="date")
     */
    private DateTimeInterface $startAt;

    /**
     * @ORM\Column(type="date")
     */
    private DateTimeInterface $endAt;

    /**
     * @ORM\ManyToOne(targetEntity=Campervan::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Campervan $campervan;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private User $customer;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $deliverAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $getAt;

    /**
     * @ORM\OneToMany(targetEntity=RentEquipment::class, mappedBy="rent", orphanRemoval=true, cascade={"persist"})
     */
    private Collection $rentEquipments;

    public function __construct(
        Station $startStation,
        Station $endStation,
        DateTimeInterface $startAt,
        DateTimeInterface $endAt,
        Campervan $campervan,
        User $customer
    ) {
        $this->startStation = $startStation;
        $this->endStation = $endStation;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
        $this->campervan = $campervan;
        $this->customer = $customer;
        $this->rentEquipments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartStation(): Station
    {
        return $this->startStation;
    }

    public function setStartStation(Station $startStation): self
    {
        $this->startStation = $startStation;

        return $this;
    }

    public function getEndStation(): Station
    {
        return $this->endStation;
    }

    public function setEndStation(Station $endStation): self
    {
        $this->endStation = $endStation;

        return $this;
    }

    public function getStartAt(): DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getCampervan(): Campervan
    {
        return $this->campervan;
    }

    public function setCampervan(Campervan $campervan): self
    {
        $this->campervan = $campervan;

        return $this;
    }

    public function getCustomer(): User
    {
        return $this->customer;
    }

    public function setCustomer(User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getDeliverAt(): ?DateTimeInterface
    {
        return $this->deliverAt;
    }

    public function setDeliverAt(DateTimeInterface $deliverAt): self
    {
        $this->deliverAt = $deliverAt;

        return $this;
    }

    public function getGetAt(): ?DateTimeInterface
    {
        return $this->getAt;
    }

    public function setGetAt(DateTimeInterface $getAt): self
    {
        $this->getAt = $getAt;

        return $this;
    }

    public function getRentEquipments(): Collection
    {
        return $this->rentEquipments;
    }

    public function addRentEquipment(Equipment $equipment, int $count): self
    {
        $rentEquipment = new RentEquipment($equipment, $count);
        $this->rentEquipments->add($rentEquipment);
        $rentEquipment->setRent($this);

        return $this;
    }
}
