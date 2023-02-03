<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MailIncomingRepository;
use App\State\MailIncomingProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MailIncomingRepository::class)]
#[ApiResource]
class MailIncoming extends Mail
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sender = null;

    #[ORM\ManyToMany(targetEntity: User::class)]
    #[Groups(groups: [
        'mail:read',
        'mail_incoming:read',
        'mail_incoming:write',
    ])]
    private Collection $recipients;

    public function __construct()
    {
        $this->recipients = new ArrayCollection();
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setSender(?string $sender): self
    {
        $this->sender = $sender;

        return $this;
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
