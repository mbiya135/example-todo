<?php

namespace Tests\Unit\Todo\Domain;

use App\Todo\Domain\Comment;
use App\Todo\Domain\Event\CommentAdded;
use App\Todo\Domain\Event\DeadlineAdded;
use App\Todo\Domain\Event\TodoAdded;
use App\Todo\Domain\Event\TodoUpdated;
use App\Todo\Domain\Todo;
use App\Todo\Domain\TodoDeadline;
use App\Todo\Domain\TodoDescription;
use App\Todo\Domain\TodoId;
use App\User\Domain\UserId;
use Spatie\EventSourcing\AggregateRoots\FakeAggregateRoot;
use Tests\TestCase;

class TodoTest extends TestCase
{
    private const UUID = '88cffeec-8c17-475b-8db0-f4092c27d011';

    /**
     * Assert creation todo
     * @test
     */
    public function can_create(): void
    {
        (new FakeAggregateRoot(
            Todo::add(
                TodoId::createFromString(self::UUID),
                TodoDescription::createFromString('Test'),
                UserId::createFromString(self::UUID)
            )
        ))->assertRecorded(
            [
                TodoAdded::createFrom(
                    TodoId::createFromString(self::UUID),
                    TodoDescription::createFromString('Test'),
                    UserId::createFromString(
                        self::UUID
                    )
                )
            ]
        );
    }

    /**
     * @test
     */
    public function can_be_updated(): void
    {
        Todo::fake(self::UUID)
            ->given(
                [
                    TodoAdded::createFrom(
                        TodoId::createFromString(self::UUID),
                        TodoDescription::createFromString('Test'),
                        UserId::createFromString(
                            self::UUID
                        )
                    ),
                ]
            )
            ->when(function (Todo $todo): void {
                $todo->update(TodoDescription::createFromString('Test Updated'));
            })
            ->assertRecorded(
                [
                    TodoUpdated::createFrom(
                        TodoId::createFromString(self::UUID),
                        TodoDescription::createFromString('Test Updated'),
                    )
                ]
            );
    }

    /**
     * @test
     */
    public function can_add_comment(): void
    {
        Todo::fake(self::UUID)
            ->given(
                [
                    TodoAdded::createFrom(
                        TodoId::createFromString(self::UUID),
                        TodoDescription::createFromString('Test'),
                        UserId::createFromString(
                            self::UUID
                        )
                    ),
                    CommentAdded::createFrom(
                        TodoId::createFromString(self::UUID),
                        Comment::from(
                            1,
                            'Test comment1',
                            UserId::createFromString(self::UUID)
                        )
                    )
                ]
            )
            ->when(function (Todo $todo): void {
                $todo->addComment(
                    Comment::from(
                        1,
                        'Test comment 2',
                        UserId::createFromString(self::UUID)
                    )
                );
            })
            ->assertRecorded(
                [
                    CommentAdded::createFrom(
                        TodoId::createFromString(self::UUID),
                        Comment::from(
                            2,
                            'Test comment 2',
                            UserId::createFromString(self::UUID)
                        )
                    )
                ]
            );
    }

    /**
     * @test
     */
    public function can_add_deadline(): void
    {
        $todoDeadline = TodoDeadline::now();
        Todo::fake(self::UUID)
            ->given(
                [
                    TodoAdded::createFrom(
                        TodoId::createFromString(self::UUID),
                        TodoDescription::createFromString('Test'),
                        UserId::createFromString(
                            self::UUID
                        )
                    ),
                ]
            )
            ->when(function (Todo $todo) use ($todoDeadline): void {
                $todo->addDeadline(
                    UserId::createFromString(self::UUID),
                    $todoDeadline
                );
            })
            ->assertRecorded(
                [
                    DeadlineAdded::createFrom(
                        TodoId::createFromString(self::UUID),
                        $todoDeadline
                    )
                ]
            );
    }
}
