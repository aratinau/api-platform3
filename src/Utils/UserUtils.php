<?php

namespace App\Utils;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class UserUtils
{
    public static function allParticipantExceptCurrentUser(User $currentUser, User $author, Collection $participants): Collection
    {
        $mergedUsers = new ArrayCollection([$author]);
        foreach ($participants as $participant) {
            if (!$mergedUsers->contains($participant)) {
                $mergedUsers->add($participant);
            }
        }

        return $mergedUsers->filter(function (User $user) use ($currentUser) {
            return $user !== $currentUser;
        });
    }
}
