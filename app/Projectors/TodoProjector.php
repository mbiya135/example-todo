<?php

namespace App\Projectors;

use App\Models\Comment;
use App\Models\Todo;
use App\Todo\Domain\Event\CommentAdded;
use App\Todo\Domain\Event\DeadlineAdded;
use App\Todo\Domain\Event\TodoAdded;
use App\Todo\Domain\Event\TodoUpdated;
use App\Todo\Domain\TodoStatus;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

final class TodoProjector extends Projector
{
    /**
     * @param TodoAdded $event
     */
    public function onTodoAdded(TodoAdded $event): void
    {
        Todo::create(
            [
                'uuid' => $event->aggregateRootUuid(),
                'description' => (string)$event->todoDescription(),
                'user_id' => (string)$event->userId(),
                'status' => TodoStatus::OPEN->value,
                'created_at' => $event->createdAt(),
            ]
        );
    }

    /**
     * @param TodoUpdated $event
     */
    public function onTodoUpdate(TodoUpdated $event): void
    {
        $todo = Todo::uuid($event->aggregateRootUuid());
        $todo->description = (string)$event->todoDescription();
        $todo->save();
    }

    /**
     * @param CommentAdded $event
     */
    public function onCommentAdded(CommentAdded $event): void
    {
        Comment::create(
            [
                'comment_id' => $event->comment()->commentId(),
                'todo_id' => $event->aggregateRootUuid(),
                'description' => $event->comment()->comment(),
                'user_id' => (string)$event->comment()->userId(),
                'created_at' => $event->createdAt(),
            ]
        );
    }

    /**
     * @param DeadlineAdded $event
     */
    public function onDeadlineAdded(DeadlineAdded $event): void
    {
        $todo = Todo::uuid($event->aggregateRootUuid());
        $todo->deadline = $event->deadline()->dateTime();
        $todo->save();
    }
}
