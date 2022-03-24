<?php

declare(strict_types=1);

namespace App\Todo\Application;

use App\Exceptions\DomainInvalidArgumentException;
use App\Todo\Domain\Repository\TodoRepository;

final class UpdateTodoHandler
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
     * @param UpdateTodo $updateTodo
     */
    public function handle(UpdateTodo $updateTodo): void
    {
        if (null === ($todo = $this->todoRepository->get($updateTodo->todoId()))) {
            throw new DomainInvalidArgumentException(
                sprintf('The todo with id %s does not exist!', (string)$updateTodo->todoId())
            );
        }
        $this->todoRepository->save(
            $todo->update($updateTodo->todoDescription())
        );
    }
}
