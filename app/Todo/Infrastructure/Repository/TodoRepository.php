<?php

declare(strict_types=1);

namespace App\Todo\Infrastructure\Repository;

use App\EventSourcing\EventStoreRepository;
use App\Todo\Domain\Repository\TodoRepository as TodoRepositoryDomain;
use App\Todo\Domain\Todo;
use App\Todo\Domain\TodoId;

final class TodoRepository extends EventStoreRepository implements TodoRepositoryDomain
{
    /**
     * @param TodoId $todoId
     * @return Todo|null
     */
    public function get(TodoId $todoId): ?Todo
    {
        $todo = $this->reconstituteFromDatabaseEvents(Todo::retrieve((string)$todoId));
        return $todo->getAppliedEvents() ? $todo : null;
    }

    /**
     * @param Todo $todo
     */
    public function save(Todo $todo): void
    {
        $this->persist($todo);
    }
}
