<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee extends Person
{
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isWearingGlasses = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isIsWearingGlasses(): ?bool
    {
        return $this->isWearingGlasses;
    }

    public function setIsWearingGlasses(?bool $isWearingGlasses): self
    {
        $this->isWearingGlasses = $isWearingGlasses;

        return $this;
    }
}
