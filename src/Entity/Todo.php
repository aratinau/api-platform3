<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Attribute\WatchProperty;
use App\Repository\TodoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource]
#[ORM\Entity(repositoryClass: TodoRepository::class)]
class Todo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(groups: ['todo:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[WatchProperty(
        events: [\Doctrine\ORM\Events::postPersist],
        triggerEventName: 'custom.event.name'
    )]
    #[Groups(groups: ['todo:read', 'todo:write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(groups: ['todo:read', 'todo:write'])]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

}
