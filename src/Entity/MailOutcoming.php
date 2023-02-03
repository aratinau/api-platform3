<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MailOutcomingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MailOutcomingRepository::class)]
#[ApiResource]
class MailOutcoming extends Mail
{
    #[ORM\ManyToOne]
    private ?User $sender = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(groups: [
        'mail:read',
        'mail_outcoming:read',
        'mail_outcoming:write',
    ])]
    private ?string $recipient = null;

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    public function setRecipient(?string $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }
}
