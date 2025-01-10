<?php

namespace App\DTO;

use App\Entity\Courier;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;

class CreateDiscussionInput
{
    #[Groups(['discussion:write'])]
    public $content;

    #[Groups(['discussion:write'])]
    private Collection $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(User $user): self
    {
        if (!$this->participants->contains($user)) {
            $this->participants->add($user);
        }

        return $this;
    }

    public function removeParticipant(User $user): self
    {
        if ($this->participants->contains($user)) {
            $this->participants->removeElement($user);
        }

        return $this;
    }

    public function setParticipants(array|ArrayCollection $participants): self
    {
        $this->participants = $participants;

        return $this;
    }
}
