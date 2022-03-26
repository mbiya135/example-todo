<?php

namespace Tests\Unit\Todo\Domain\Event;

use App\Todo\Domain\Event\TodoAdded;
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
        $event = TodoAdded::fromArray(
            [
                'todo_id' => self::UUID,
                'user_id' => self::UUID,
                'description' => 'Test',
            ],
            []
        );
        $this->assertSame(self::UUID, (string)$event->todoId());
        $this->assertSame(self::UUID, (string)$event->userId());
        $this->assertSame('Test', (string)$event->todoDescription());
        $this->assertSame(
            [
                'todo_id' => self::UUID,
                'user_id' => self::UUID,
                'description' => 'Test',
            ],
            $event->toArray()
        );
    }
}
