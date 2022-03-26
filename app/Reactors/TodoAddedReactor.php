<?php

namespace App\Reactors;

use App\Todo\Domain\Event\TodoAdded;
use App\User\Application\AttacheTodo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Bus;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

final class TodoAddedReactor extends Reactor implements ShouldQueue
{
    /**
     * @param TodoAdded $event
     */
    public function __invoke(TodoAdded $event): void
    {
        Bus::dispatch(
            AttacheTodo::fromPayload(
                [
                    'user_id' => (string)$event->userId(),
                    'todo_id' => (string)$event->userId(),
                ]
            )
        );
    }
}
