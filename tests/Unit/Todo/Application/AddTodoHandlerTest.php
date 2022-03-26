<?php

namespace Tests\Unit\Todo\Application;

use App\Exceptions\DomainInvalidArgumentException;
use App\Todo\Application\AddTodo;
use App\Todo\Application\AddTodoHandler;
use App\Todo\Domain\Repository\TodoRepository;
use App\Todo\Domain\Todo;
use App\Todo\Domain\TodoDescription;
use App\Todo\Domain\TodoId;
use App\User\Domain\UserId;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class AddTodoHandlerTest extends TestCase
{
    private const UUID = '88cffeec-8c17-475b-8db0-f4092c27d011';

    /**
     * @test
     */
    public function can_add_todo(): void
    {
        $repository = Mockery::mock(
            TodoRepository::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('get')
                    ->once()
                    ->andReturn(null);
                $mock->shouldReceive('save')
                    ->once()
                    ->andReturn(null);
            }
        );
        $addTodoHandler = new AddTodoHandler($repository);
        $addTodoHandler->handle(
            AddTodo::fromPayload(
                [
                    'todo_id' => self::UUID,
                    'user_id' => self::UUID,
                    'todo_description' => 'Test'
                ]
            )
        );
    }

    /**
     * @test
     */
    public function cannot_add_todo_with_existing_id(): void
    {
        $this->expectException(DomainInvalidArgumentException::class);
        $repository = Mockery::mock(
            TodoRepository::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('get')
                    ->once()
                    ->andReturn(
                        Todo::add(
                            TodoId::createFromString(self::UUID),
                            TodoDescription::createFromString('Test'),
                            UserId::createFromString(self::UUID)
                        )
                    );
            }
        );
        $addTodoHandler = new AddTodoHandler($repository);
        $addTodoHandler->handle(
            AddTodo::fromPayload(
                [
                    'todo_id' => self::UUID,
                    'user_id' => self::UUID,
                    'todo_description' => 'Test'
                ]
            )
        );
    }
}
