<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: VehicleModel::class, inversedBy: 'vehicles')]
    #[ORM\JoinColumn(nullable: false)]
    private $model;

    #[ORM\Column(type: 'string', length: 255)]
    private $numberplate;

    #[ORM\ManyToOne(targetEntity: Citizen::class, inversedBy: 'vehicles')]
    private $owner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?VehicleModel
    {
        return $this->model;
    }

    public function setModel(?VehicleModel $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getNumberplate(): ?string
    {
        return $this->numberplate;
    }

    public function setNumberplate(string $numberplate): self
    {
        $this->numberplate = $numberplate;

        return $this;
    }

    public function getOwner(): ?Citizen
    {
        return $this->owner;
    }

    public function setOwner(?Citizen $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
