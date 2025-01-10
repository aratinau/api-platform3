<?php

namespace App\DoctrineListener\Discussion;

use App\Entity\Discussion\Message;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;

#[AsEntityListener(event: Events::postLoad, entity: Message::class)]
class ReadMessageNotificationListener
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function postLoad(Message $message, PostLoadEventArgs $event): void
    {
        $user = $this->security->getUser();

        foreach ($message->getDiscussion()->getDiscussionParticipant() as $discussionParticipant) {
            $discussionParticipant->setRead(false);
            if ($discussionParticipant->getParticipant() === $user) {
                $discussionParticipant->setRead(true);
            }

            $this->entityManager->persist($discussionParticipant);
        }

        foreach ($message->getMessageNotifications() as $messageNotification) {
            if ($messageNotification->getParticipant() !== $user) {
                continue;
            }

            $messageNotification->setRead(true);
            $this->entityManager->persist($messageNotification);
        }
        $this->entityManager->flush();
    }
}
