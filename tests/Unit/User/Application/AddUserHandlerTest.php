<?php

namespace Tests\Unit\User\Application;

use App\Exceptions\DomainInvalidArgumentException;
use App\User\Application\AddUser;
use App\User\Application\AddUserHandler;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\User;
use App\User\Domain\UserEmail;
use App\User\Domain\UserId;
use App\User\Domain\UserName;
use App\User\Domain\UserPassword;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class AddUserHandlerTest extends TestCase
{
    private const UUID = '88cffeec-8c17-475b-8db0-f4092c27d011';

    /**
     * @test
     */
    public function can_add_user(): void
    {
        $repository = Mockery::mock(
            UserRepository::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('get')
                    ->once()
                    ->andReturn(null);
                $mock->shouldReceive('save')
                    ->once()
                    ->andReturn(null);
            }
        );
        $addTodoHandler = new AddUserHandler($repository);
        $addTodoHandler->handle(
            AddUser::fromPayload(
                [
                    'user_id' => self::UUID,
                    'user_name' => 'Test',
                    'user_email' => 'test@testphpunut.com',
                    'user_password' => '1234',
                ]
            )
        );
    }

    /**
     * @test
     */
    public function cannot_add_user_with_existing_id(): void
    {
        $this->expectException(DomainInvalidArgumentException::class);
        $repository = Mockery::mock(
            UserRepository::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('get')
                    ->once()
                    ->andReturn(
                        User::add(
                            UserId::createFromString(self::UUID),
                            UserName::createFromString('test'),
                            UserEmail::createFromString('test@testphpunit.com'),
                            UserPassword::createFromString('1234')
                        )
                    );
            }
        );
        $addTodoHandler = new AddUserHandler($repository);
        $addTodoHandler->handle(
            AddUser::fromPayload(
                [
                    'user_id' => self::UUID,
                    'user_name' => 'Test',
                    'user_email' => 'test@testphpunut.com',
                    'user_password' => '1234',
                ]
            )
        );
    }
}
