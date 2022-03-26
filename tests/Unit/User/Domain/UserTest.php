<?php

namespace Tests\Unit\User\Domain;

use App\Todo\Domain\TodoId;
use App\User\Domain\Event\TodoAttached;
use App\User\Domain\Event\UserAdded;
use App\User\Domain\User;
use App\User\Domain\UserEmail;
use App\User\Domain\UserId;
use App\User\Domain\UserName;
use App\User\Domain\UserPassword;
use Spatie\EventSourcing\AggregateRoots\FakeAggregateRoot;
use Tests\TestCase;

class UserTest extends TestCase
{
    private const UUID = '88cffeec-8c17-475b-8db0-f4092c27d011';

    /**
     * Assert creation todo
     * @test
     */
    public function can_create(): void
    {
        (new FakeAggregateRoot(
            User::add(
                UserId::createFromString(self::UUID),
                UserName::createFromString('Test'),
                UserEmail::createFromString('Test'),
                UserPassword::createFromString('test')
            )
        ))->assertRecorded(
            [
                UserAdded::createFrom(
                    UserId::createFromString(self::UUID),
                    UserName::createFromString('Test'),
                    UserEmail::createFromString('Test'),
                    UserPassword::createFromString('test')
                )
            ]
        );
    }

    /**
     * @test
     */
    public function can_attache_todo(): void
    {
        User::fake(self::UUID)
            ->given(
                [
                    UserAdded::createFrom(
                        UserId::createFromString(self::UUID),
                        UserName::createFromString('Test'),
                        UserEmail::createFromString('Test'),
                        UserPassword::createFromString('test')
                    )
                ]
            )
            ->when(function (User $user): void {
                $user->attacheTodo(TodoId::createFromString(self::UUID));
            })
            ->assertRecorded(
                [
                    TodoAttached::createFrom(
                        UserId::createFromString(self::UUID),
                        TodoId::createFromString(self::UUID),
                    )
                ]
            );
    }
}
