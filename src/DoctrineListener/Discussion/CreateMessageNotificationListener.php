<?php

namespace App\DoctrineListener\Discussion;

use App\Entity\Discussion\Message;
use App\Entity\Discussion\MessageNotification;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;

#[AsEntityListener(event: Events::postPersist, entity: Message::class)]
class CreateMessageNotificationListener
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security $security
    ) {}

    public function postPersist(Message $message, PostPersistEventArgs $event): void
    {
        $user = $this->security->getUser();

        // DiscussionParticipant
        foreach ($message->getDiscussion()->getDiscussionParticipant() as $discussionParticipant) {
            $discussionParticipant->setRead(false);
            if ($discussionParticipant->getParticipant() === $user) {
                // $discussionParticipant->setRead(true);
            }

            $this->entityManager->persist($discussionParticipant);
        }

        // MessageNotification
        $discussionParticipants = $message->getDiscussion()->getDiscussionParticipant();
        foreach ($discussionParticipants as $discussionParticipant) {
            $messageNotification = new MessageNotification();
            $messageNotification->setParticipant($discussionParticipant->getParticipant());
            $messageNotification->setMessage($message);
            if ($message->getAuthor() === $discussionParticipant->getParticipant()) {
                $messageNotification->setRead(true);
            }

            $this->entityManager->persist($messageNotification);
        }

        $this->entityManager->flush();
    }
}
