<?php

namespace App\Entity;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\EntityZRepository;
use App\State\EntityZProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EntityZRepository::class)]
#[Post(processor: EntityZProcessor::class)]
#[GetCollection]
class EntityZ extends EntityX
{
    #[ORM\ManyToMany(targetEntity: User::class)]
    #[Groups(groups: ['entity_z:read', 'entity_z:write'])]
    private Collection $recipients;

    public function __construct()
    {
        $this->recipients = new ArrayCollection();
    }

    /**
     * @return Collection<int, User>
     */
    public function getRecipients(): Collection
    {
        return $this->recipients;
    }

    public function addRecipient(User $recipient): self
    {
        if (!$this->recipients->contains($recipient)) {
            $this->recipients->add($recipient);
        }

        return $this;
    }

    public function removeRecipient(User $recipient): self
    {
        $this->recipients->removeElement($recipient);

        return $this;
    }
}
