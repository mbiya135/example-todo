<?php

namespace App\Projectors;

use App\Models\User;
use App\User\Domain\Event\UserAdded;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

final class UserProjector extends projector
{
    /**
     * @param UserAdded $event
     */
    public function onUserAdded(UserAdded $event): void
    {
        User::create(
            [
                'uuid' => $event->aggregaterootuuid(),
                'name' => (string)$event->userName(),
                'email' => (string)$event->userEmail(),
                'password' => (string)$event->userPassword(),
                'created_at' => $event->createdAt(),
            ]
        );
    }
}
