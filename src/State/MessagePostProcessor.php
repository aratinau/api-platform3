<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Message;
use App\Repository\DiscussionRepository;
use Doctrine\ORM\EntityManagerInterface;

class MessagePostProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly DiscussionRepository $discussionRepository
    ) {
    }

    /**
     * @param Message $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $discussion = $this->discussionRepository->find($uriVariables['id']);

        $discussion->addMessage($data);

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}
