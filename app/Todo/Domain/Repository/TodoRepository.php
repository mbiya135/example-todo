<?php

declare(strict_types=1);

namespace App\Todo\Domain\Repository;

use App\Todo\Domain\Todo;
use App\Todo\Domain\TodoId;

interface TodoRepository
{
    /**
     * @param TodoId $todoId
     * @return Todo|null
     */
    public function get(TodoId $todoId): ?Todo;

    /**
     * @param Todo $todo
     */
    public function save(Todo $todo): void;
}
