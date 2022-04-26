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
    private $Model;

    #[ORM\Column(type: 'string', length: 255)]
    private $Numberplate;

    #[ORM\ManyToOne(targetEntity: Citizen::class, inversedBy: 'vehicles')]
    private $Owner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?VehicleModel
    {
        return $this->Model;
    }

    public function setModel(?VehicleModel $Model): self
    {
        $this->Model = $Model;

        return $this;
    }

    public function getNumberplate(): ?string
    {
        return $this->Numberplate;
    }

    public function setNumberplate(string $Numberplate): self
    {
        $this->Numberplate = $Numberplate;

        return $this;
    }

    public function getOwner(): ?Citizen
    {
        return $this->Owner;
    }

    public function setOwner(?Citizen $Owner): self
    {
        $this->Owner = $Owner;

        return $this;
    }
}
