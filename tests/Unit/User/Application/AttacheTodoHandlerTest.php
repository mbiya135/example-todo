<?php

namespace Tests\Unit\User\Application;

use App\Exceptions\DomainInvalidArgumentException;
use App\User\Application\AttacheTodo;
use App\User\Application\AttacheTodoHandler;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\User;
use App\User\Domain\UserEmail;
use App\User\Domain\UserId;
use App\User\Domain\UserName;
use App\User\Domain\UserPassword;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class AttacheTodoHandlerTest extends TestCase
{
    private const UUID = '88cffeec-8c17-475b-8db0-f4092c27d011';

    /**
     * @test
     */
    public function can_attache_todo(): void
    {
        $user = User::add(
            UserId::createFromString(self::UUID),
            UserName::createFromString('test'),
            UserEmail::createFromString('test@testphpunit.com'),
            UserPassword::createFromString('1234')
        );
        $repository = Mockery::mock(
            UserRepository::class,
            function (MockInterface $mock) use ($user) {
                $mock->shouldReceive('get')
                    ->once()
                    ->andReturn($user);
                $mock->shouldReceive('save')
                    ->once()
                    ->andReturn(null);
            }
        );
        $updateTodoHandler = new AttacheTodoHandler($repository);
        $updateTodoHandler->handle(
            AttacheTodo::fromPayload(
                [
                    'todo_id' => self::UUID,
                    'user_id' => self::UUID
                ]
            )
        );
        $this->assertCount(2, $user->getRecordedEvents());
    }

    /**
     * @test
     */
    public function cannot_attache_todo_does_not_exist(): void
    {
        $this->expectException(DomainInvalidArgumentException::class);
        $repository = Mockery::mock(
            UserRepository::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('get')
                    ->once()
                    ->andReturn(null);
            }
        );
        $updateTodoHandler = new AttacheTodoHandler($repository);
        $updateTodoHandler->handle(
            AttacheTodo::fromPayload(
                [
                    'todo_id' => self::UUID,
                    'user_id' => self::UUID
                ]
            )
        );
    }
}
