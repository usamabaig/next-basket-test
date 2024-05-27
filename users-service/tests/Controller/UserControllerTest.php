<?php

namespace App\Tests\Controller;

use App\Message\Command\CreateUserCommand;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\InMemory\InMemoryTransport;

class UserControllerTest extends WebTestCase
{
    public function testCreateUser()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $container->set('messenger.transport.async', new InMemoryTransport());

        $client->request(
            'POST',
            '/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test@example.com',
                'firstName' => 'Test',
                'lastName' => 'User'
            ])
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        /** @var InMemoryTransport $transport */
        $transport = $container->get('messenger.transport.async');
        $this->assertCount(1, $transport->getSent());

        /** @var Envelope $envelope */
        $envelope = $transport->getSent()[0];
        $dispatchedMessage = $envelope->getMessage();

        $this->assertInstanceOf(CreateUserCommand::class, $dispatchedMessage);
        $this->assertEquals('test@example.com', $dispatchedMessage->getEmail());
        $this->assertEquals('Test', $dispatchedMessage->getFirstName());
        $this->assertEquals('User', $dispatchedMessage->getLastName());
    }
}