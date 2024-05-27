<?php

namespace App\MessageHandler;

use App\Message\Command\CreateUserCommand;
use App\Message\Event\UserCreatedEvent;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserCommandHandler
{
    private $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateUserCommand $command)
    {
        $userId = uniqid();

        $this->eventBus->dispatch(new UserCreatedEvent(
            $userId,
            $command->getEmail(),
            $command->getFirstName(),
            $command->getLastName()
        ));
    }
}
