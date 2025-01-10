<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Discussion\Message;
use App\Repository\DiscussionRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class MessagePostProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private readonly DiscussionRepository $discussionRepository,
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
        $data->setDiscussion($discussion);

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
