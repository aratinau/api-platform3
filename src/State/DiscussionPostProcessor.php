<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DTO\CreateDiscussionInput;
use App\Entity\Discussion\Discussion;
use App\Entity\Discussion\DiscussionNotification;
use App\Entity\Discussion\Message;
use App\Entity\Discussion\DiscussionParticipant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class DiscussionPostProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private Security $security,
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @param CreateDiscussionInput $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return Discussion
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Discussion
    {
        $user = $this->security->getUser();

        $message = new Message();
        $message->setContent($data->content);

        $discussion = new Discussion();
        $discussion->addMessage($message);
        $discussion->setAuthor($user);

        // DiscussionParticipant for current user - use Collection to avoid doublon
        $data->addParticipant($user);

        foreach ($data->getParticipants() as $participant) {
            $discussionParticipant = new DiscussionParticipant();
            $discussionParticipant->setParticipant($participant);
            $discussionParticipant->setDiscussion($discussion);

            if ($participant === $user) {
                $discussionParticipant->setRead(true);
            }

            $discussion->addDiscussionParticipant($discussionParticipant);
        }

        $discussion->addDiscussionParticipant($discussionParticipant);

        return $this->persistProcessor->process($discussion, $operation, $uriVariables, $context);
    }
}
