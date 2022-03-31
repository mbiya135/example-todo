<?php

namespace Tests\Unit\User\Domain\Event;

use App\User\Domain\Event\UserAdded;
use Tests\TestCase;

class UserAddedTest extends TestCase
{
    private const UUID = '88cffeec-8c17-475b-8db0-f4092c27d011';

    /**
     * Assert creation event
     * @test
     */
    public function can_create_from(): void
    {
        $event = UserAdded::fromArray(
            [
                'user_id' => self::UUID,
                'user_name' => 'Test',
                'user_email' => 'test@testphpunit.com',
                'user_password' => '1234',
            ],
            []
        );
        $this->assertSame(self::UUID, (string)$event->userId());
        $this->assertSame('Test', (string)$event->userName());
        $this->assertSame('test@testphpunit.com', (string)$event->userEmail());
        $this->assertSame('1234', (string)$event->userPassword());
        $this->assertSame(
            [
                'user_id' => self::UUID,
                'user_name' => 'Test',
                'user_email' => 'test@testphpunit.com',
                'user_password' => '1234',
            ],
            $event->toArray()
        );
    }
}
