<?php

namespace Tests\Unit\Todo\Domain\Event;

use App\Todo\Domain\Event\CommentAdded;
use Tests\TestCase;

class CommentAddedTest extends TestCase
{
    private const UUID = '88cffeec-8c17-475b-8db0-f4092c27d011';

    /**
     * Assert creation event
     * @test
     */
    public function can_create_from(): void
    {
        $event = CommentAdded::fromArray(
            [
                'todo_id' => self::UUID,
                'comment' => 'Test',
                'comment_id' => 1,
                'user_id' => self::UUID,
            ],
            []
        );

        $this->assertSame(self::UUID, (string)$event->todoId());
        $this->assertSame('Test', $event->comment()->comment());
        $this->assertSame(
            [
                'todo_id' => self::UUID,
                'comment_id' => 1,
                'user_id' => self::UUID,
                'comment' => 'Test',
            ],
            $event->toArray()
        );
    }
}
