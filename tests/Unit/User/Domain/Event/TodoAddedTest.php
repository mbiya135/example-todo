<?php

namespace Tests\Unit\User\Domain\Event;

use App\User\Domain\Event\TodoAttached;
use Tests\TestCase;

class TodoAddedTest extends TestCase
{
    private const UUID = '88cffeec-8c17-475b-8db0-f4092c27d011';

    /**
     * Assert creation event
     * @test
     */
    public function can_create_from(): void
    {
        $event = TodoAttached::fromArray(
            [
                'user_id' => self::UUID,
                'todo_id' => self::UUID,
            ],
            []
        );
        $this->assertSame(self::UUID, (string)$event->userId());
        $this->assertSame(self::UUID, (string)$event->todoId());
        $this->assertSame(
            [
                'user_id' => self::UUID,
                'todo_id' => self::UUID,
            ],
            $event->toArray()
        );
    }
}
