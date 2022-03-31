<?php

namespace Tests\Unit\Todo\Domain\Event;

use App\Todo\Domain\Event\DeadlineAdded;
use Carbon\CarbonImmutable;
use DateTimeInterface;
use Tests\TestCase;

class DeadlineAddedTest extends TestCase
{
    private const UUID = '88cffeec-8c17-475b-8db0-f4092c27d011';

    /**
     * Assert creation event
     * @test
     */
    public function can_create_from(): void
    {
        $date = CarbonImmutable::now();
        $event = DeadlineAdded::fromArray(
            [
                'todo_id' => self::UUID,
                'deadline' => $date->toString(),
            ],
            []
        );
        $this->assertSame(self::UUID, (string)$event->todoId());
        $this->assertSame(
            $date->format(DateTimeInterface::ATOM),
            $event->deadline()->dateTime()->format(DateTimeInterface::ATOM)
        );
        $this->assertSame(
            [
                'todo_id' => self::UUID,
                'deadline' => $date->format(DateTimeInterface::ATOM),
            ],
            $event->toArray()
        );
    }
}
