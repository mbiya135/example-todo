<?php

namespace Tests\Unit\Todo\Application;

use App\Exceptions\DomainInvalidArgumentException;
use App\Todo\Application\AddComment;
use App\Todo\Application\AddCommentHandler;
use App\Todo\Domain\Repository\TodoRepository;
use App\Todo\Domain\Todo;
use App\Todo\Domain\TodoDescription;
use App\Todo\Domain\TodoId;
use App\User\Domain\UserId;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class AddCommentHandlerTest extends TestCase
{
    private const UUID = '88cffeec-8c17-475b-8db0-f4092c27d011';

    /**
     * @test
     */
    public function can_add_comment_todo(): void
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
        $addCommentHandler = new AddCommentHandler($repository);
        $addCommentHandler->handle(
            AddComment::fromPayload(
                [
                    'todo_id' => self::UUID,
                    'user_id' => self::UUID,
                    'comment' => 'test'
                ]
            )
        );
        $this->assertCount(2, $todo->getRecordedEvents());
    }

    /**
     * @test
     */
    public function cannot_add_comment_todo_does_not_exist(): void
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
        $addCommentHandler = new AddCommentHandler($repository);
        $addCommentHandler->handle(
            AddComment::fromPayload(
                [
                    'todo_id' => self::UUID,
                    'user_id' => self::UUID,
                    'comment' => 'test'
                ]
            )
        );
    }
}
