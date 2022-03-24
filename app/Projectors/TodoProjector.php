<?php

namespace App\Projectors;

use App\Models\Todo;
use App\Todo\Domain\Event\TodoAdded;
use App\Todo\Domain\Event\TodoUpdated;
use App\Todo\Domain\TodoStatus;
use Composer\XdebugHandler\Status;
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
}
