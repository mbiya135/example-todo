<?php

declare(strict_types=1);

namespace App\Todo\Infrastructure\Repository;

use App\Todo\Domain\Repository\TodoRepository as TodoRepositoryDomain;
use App\Todo\Domain\Todo;
use App\Todo\Domain\TodoId;

final class TodoRepository implements TodoRepositoryDomain
{
    /**
     * @param TodoId $todoId
     * @return Todo
     */
    public function get(TodoId $todoId): Todo
    {
        return Todo::retrieve($todoId->toString());
    }

    /**
     * @param Todo $todo
     */
    public function save(Todo $todo): void
    {
        $todo->persist();
    }
}
