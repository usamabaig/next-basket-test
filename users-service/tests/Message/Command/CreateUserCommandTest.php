<?php

namespace App\Tests\Message\Command;

use App\Message\Command\CreateUserCommand;
use PHPUnit\Framework\TestCase;

class CreateUserCommandTest extends TestCase
{
    public function testCreateUserCommand()
    {
        $command = new CreateUserCommand('test@example.com', 'Test', 'User');

        $this->assertEquals('test@example.com', $command->getEmail());
        $this->assertEquals('Test', $command->getFirstName());
        $this->assertEquals('User', $command->getLastName());
    }
}