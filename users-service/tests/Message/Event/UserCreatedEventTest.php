<?php

namespace App\Tests\Message\Event;

use App\Message\Event\UserCreatedEvent;
use PHPUnit\Framework\TestCase;

class UserCreatedEventTest extends TestCase
{
    public function testUserCreatedEvent()
    {
        $event = new UserCreatedEvent('1', 'test@example.com', 'Test', 'User');

        $this->assertEquals('1', $event->getId());
        $this->assertEquals('test@example.com', $event->getEmail());
        $this->assertEquals('Test', $event->getFirstName());
        $this->assertEquals('User', $event->getLastName());
    }
}
