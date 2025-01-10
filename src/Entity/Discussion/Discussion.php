<?php

namespace App\Entity\Discussion;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\DTO\CreateDiscussionInput;
use App\Entity\AuthorInterface;
use App\Entity\User;
use App\Repository\DiscussionRepository;
use App\State\DiscussionPostProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DiscussionRepository::class)]
#[Post(
    input: CreateDiscussionInput::class,
    processor: DiscussionPostProcessor::class
)]
#[ApiResource]
class Discussion implements AuthorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(groups: ['discussion:read'])]
    private ?User $author = null;

    #[ORM\OneToMany(mappedBy: 'discussion', targetEntity: Message::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $messages;

    #[Groups(groups: ['discussion:write'])]
    private string $content;

    /**
     * @var Collection<int, DiscussionParticipant>
     */
    #[ORM\OneToMany(mappedBy: 'discussion', targetEntity: DiscussionParticipant::class, cascade: ['persist'], orphanRemoval: true)]
    #[Groups(groups: ['discussion:read'])]
    private Collection $discussionParticipant;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->discussionParticipant = new ArrayCollection();
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

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setDiscussion($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getDiscussion() === $this) {
                $message->setDiscussion(null);
            }
        }

        return $this;
    }

    public function setContent(string $content): self
    {
        $msg = new Message();

        $msg->setContent($content);
        $this->addMessage($msg);

        return $this;
    }

    /**
     * @return Collection<int, DiscussionParticipant>
     */
    public function getDiscussionParticipant(): Collection
    {
        return $this->discussionParticipant;
    }

    public function addDiscussionParticipant(DiscussionParticipant $participant): static
    {
        if (!$this->discussionParticipant->contains($participant)) {
            $this->discussionParticipant->add($participant);
            $participant->setDiscussion($this);
        }

        return $this;
    }

    public function removeDiscussionParticipant(DiscussionParticipant $participant): static
    {
        if ($this->discussionParticipant->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getDiscussion() === $this) {
                $participant->setDiscussion(null);
            }
        }

        return $this;
    }

    public function getParticipants(): Collection
    {
        $participants = new ArrayCollection();
        $discussionParticipants = $this->getDiscussionParticipant();

        foreach ($discussionParticipants as $discussionParticipant) {
            $participants->add($discussionParticipant->getParticipant());
        }

        return $participants;
    }
}
