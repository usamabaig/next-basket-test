<?php

namespace App\Tests\MessageHandler;

use App\Message\Command\CreateUserCommand;
use App\Message\Event\UserCreatedEvent;
use App\MessageHandler\CreateUserCommandHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Transport\InMemory\InMemoryTransport;

class CreateUserCommandHandlerTest extends TestCase
{
    private $inMemoryTransport;
    private $messageBus;
    private $handler;

    protected function setUp(): void
    {
        $this->inMemoryTransport = new InMemoryTransport();
        $this->messageBus = $this->createMock(MessageBusInterface::class);
        $this->messageBus->method('dispatch')
            ->willReturnCallback(function ($message) {
                return $this->inMemoryTransport->send(new Envelope($message));
            });

        $this->handler = new CreateUserCommandHandler($this->messageBus);
    }

    public function testHandleCreateUserCommand()
    {
        $command = new CreateUserCommand('test@example.com', 'Test', 'User');
        $this->handler->__invoke($command);

        $this->assertCount(1, $this->inMemoryTransport->getSent());

        /** @var Envelope $envelope */
        $envelope = $this->inMemoryTransport->getSent()[0];
        $dispatchedMessage = $envelope->getMessage();

        $this->assertInstanceOf(UserCreatedEvent::class, $dispatchedMessage);
        $this->assertEquals('test@example.com', $dispatchedMessage->getEmail());
        $this->assertEquals('Test', $dispatchedMessage->getFirstName());
        $this->assertEquals('User', $dispatchedMessage->getLastName());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->inMemoryTransport, $this->messageBus, $this->handler);
    }
}