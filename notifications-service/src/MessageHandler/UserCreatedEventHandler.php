<?php

namespace App\MessageHandler;

use App\Message\Event\UserCreatedEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Filesystem\Filesystem;

#[AsMessageHandler]
class UserCreatedEventHandler
{
    private string $logFilePath;

    public function __construct(string $logFilePath = '/app/logs/notifications.log')
    {
        $this->logFilePath = $logFilePath;
    }

    public function __invoke(UserCreatedEvent $event)
    {
        $filesystem = new Filesystem();
        $filesystem->appendToFile($this->logFilePath, json_encode([
                'id' => $event->getId(),
                'email' => $event->getEmail(),
                'firstName' => $event->getFirstName(),
                'lastName' => $event->getLastName(),
            ]) . PHP_EOL);
    }
}