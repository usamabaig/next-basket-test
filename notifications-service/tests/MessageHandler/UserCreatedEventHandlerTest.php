<?php

namespace App\Tests\MessageHandler;

use App\Message\Event\UserCreatedEvent;
use App\MessageHandler\UserCreatedEventHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class UserCreatedEventHandlerTest extends TestCase
{
    private string $logFilePath;

    public function setUp(): void
    {
        $this->logFilePath = sys_get_temp_dir() . '/notifications.log';

        // Clear the log file before each test
        if (file_exists($this->logFilePath)) {
            unlink($this->logFilePath);
        }
    }

    public function testUserCreatedEventIsHandled()
    {
        $event = new UserCreatedEvent('1', 'test@example.com', 'Test', 'User');

        $handler = new UserCreatedEventHandler($this->logFilePath);
        $handler->__invoke($event);

        $this->assertFileExists($this->logFilePath);

        $logContent = file_get_contents($this->logFilePath);
        $this->assertStringContainsString('"id":"1"', $logContent);
        $this->assertStringContainsString('"email":"test@example.com"', $logContent);
        $this->assertStringContainsString('"firstName":"Test"', $logContent);
        $this->assertStringContainsString('"lastName":"User"', $logContent);
    }
}
