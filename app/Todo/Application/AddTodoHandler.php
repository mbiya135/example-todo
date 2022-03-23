<?php

declare(strict_types=1);

namespace App\Todo\Application;

use App\Todo\Domain\Repository\TodoRepository;
use App\Todo\Domain\Todo;

final class AddTodoHandler
{
    /**
     * @var TodoRepository
     */
    private TodoRepository $todoRepository;

    /**
     * @param TodoRepository $todoRepository
     */
    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    /**
     * @param AddTodo $addTodo
     */
    public function handle(AddTodo $addTodo): void
    {
        $this->todoRepository->save(
            Todo::add(
                $addTodo->todoId(),
                $addTodo->todoDescription(),
                $addTodo->userId(),
            )
        );
    }
}
