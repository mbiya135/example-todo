<?php

namespace Tests\Unit\Todo\Application;

use App\Exceptions\DomainInvalidArgumentException;
use App\Todo\Application\AddDeadline;
use App\Todo\Application\AddDeadlineHandler;
use App\Todo\Domain\Repository\TodoRepository;
use App\Todo\Domain\Todo;
use App\Todo\Domain\TodoDeadline;
use App\Todo\Domain\TodoDescription;
use App\Todo\Domain\TodoId;
use App\User\Domain\UserId;
use Exception;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class AddDeadlineHandlerTest extends TestCase
{
    private const UUID = '88cffeec-8c17-475b-8db0-f4092c27d011';

    /**
     * @test
     * @throws Exception
     */
    public function can_add_deadline_todo(): void
    {
        $todo = Todo::add(
            TodoId::createFromString(self::UUID),
            TodoDescription::createFromString('Test'),
            UserId::createFromString(self::UUID)
        );
        $repository = Mockery::mock(
            TodoRepository::class,
            function (MockInterface $mock) use ($todo) {
                $mock->shouldReceive('get')
                    ->once()
                    ->andReturn($todo);
                $mock->shouldReceive('save')
                    ->once()
                    ->andReturn(null);
            }
        );
        $addDeadlineHandler = new AddDeadlineHandler($repository);
        $addDeadlineHandler->handle(
            AddDeadline::fromPayload(
                [
                    'todo_id' => self::UUID,
                    'user_id' => self::UUID,
                    'deadline' => (string)TodoDeadline::now(),
                ]
            )
        );
        $this->assertCount(2, $todo->getRecordedEvents());
    }

    /**
     * @test
     * @throws Exception
     */
    public function cannot_add_deadline_todo_does_not_exist(): void
    {
        $this->expectException(DomainInvalidArgumentException::class);
        $repository = Mockery::mock(
            TodoRepository::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('get')
                    ->once()
                    ->andReturn(null);
            }
        );
        $addDeadlineHandler = new AddDeadlineHandler($repository);
        $addDeadlineHandler->handle(
            AddDeadline::fromPayload(
                [
                    'todo_id' => self::UUID,
                    'user_id' => self::UUID,
                    'deadline' => (string)TodoDeadline::now(),
                ]
            )
        );
    }
}
