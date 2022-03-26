<?php

namespace Tests\Unit\Todo\Application;

use App\Exceptions\DomainInvalidArgumentException;
use App\Todo\Application\UpdateTodo;
use App\Todo\Application\UpdateTodoHandler;
use App\Todo\Domain\Repository\TodoRepository;
use App\Todo\Domain\Todo;
use App\Todo\Domain\TodoDescription;
use App\Todo\Domain\TodoId;
use App\User\Domain\UserId;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class UpdateTodoHandlerTest extends TestCase
{
    private const UUID = '88cffeec-8c17-475b-8db0-f4092c27d011';

    /**
     * @test
     */
    public function can_update_todo(): void
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
        $updateTodoHandler = new UpdateTodoHandler($repository);
        $updateTodoHandler->handle(
            UpdateTodo::fromPayload(
                [
                    'todo_id' => self::UUID,
                    'todo_description' => 'Test'
                ]
            )
        );
        $this->assertCount(2, $todo->getRecordedEvents());
    }

    /**
     * @test
     */
    public function cannot_update_todo_does_not_exist(): void
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
        $updateTodoHandler = new UpdateTodoHandler($repository);
        $updateTodoHandler->handle(
            UpdateTodo::fromPayload(
                [
                    'todo_id' => self::UUID,
                    'todo_description' => 'Test'
                ]
            )
        );
    }
}
