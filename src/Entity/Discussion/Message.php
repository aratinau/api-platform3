<?php

namespace App\Entity\Discussion;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Entity\AuthorInterface;
use App\Entity\User;
use App\Repository\MessageRepository;
use App\State\MessagePostProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ApiResource]
#[Post(
    uriTemplate: '/discussions/{id}/message',
    read: false,
    processor: MessagePostProcessor::class
)]
#[ApiResource(
    uriTemplate: '/discussions/{id}/messages.{_format}',
    operations: [new GetCollection()],
    uriVariables: [
        'id' => new Link(
            fromProperty: 'messages',
            fromClass: Discussion::class,
        ),
    ],
)]
class Message implements AuthorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(groups: ['message:read', 'discussion:read'])]
    private ?User $author = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(groups: ['message:read', 'message:write'])]
    #[Assert\NotBlank()]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Discussion $discussion = null;

    /**
     * @var Collection<int, MessageNotification>
     */
    #[ORM\OneToMany(mappedBy: 'message', targetEntity: MessageNotification::class, orphanRemoval: true)]
    #[Groups(groups: ['message:read'])]
    private Collection $messageNotifications;

    public function __construct()
    {
        $this->messageNotifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDiscussion(): ?Discussion
    {
        return $this->discussion;
    }

    public function setDiscussion(?Discussion $discussion): self
    {
        $this->discussion = $discussion;

        return $this;
    }

    /**
     * @return Collection<int, MessageNotification>
     */
    public function getMessageNotifications(): Collection
    {
        return $this->messageNotifications;
    }

    public function addMessageNotification(MessageNotification $messageNotification): static
    {
        if (!$this->messageNotifications->contains($messageNotification)) {
            $this->messageNotifications->add($messageNotification);
            $messageNotification->setMessage($this);
        }

        return $this;
    }

    public function removeMessageNotification(MessageNotification $messageNotification): static
    {
        if ($this->messageNotifications->removeElement($messageNotification)) {
            // set the owning side to null (unless already changed)
            if ($messageNotification->getMessage() === $this) {
                $messageNotification->setMessage(null);
            }
        }

        return $this;
    }
}
