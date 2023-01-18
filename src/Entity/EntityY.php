<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\EntityYRepository;
use App\State\EntityYProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EntityYRepository::class)]
#[ApiResource(shortName: 'entity_ys')]
#[Post(processor: EntityYProcessor::class)]
#[GetCollection]
class EntityY extends EntityX
{
    #[ORM\Column(length: 255)]
    #[Groups(groups: ['entity_y:read', 'entity_y:write'])]
    private ?string $recipient = null;

    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }
}
