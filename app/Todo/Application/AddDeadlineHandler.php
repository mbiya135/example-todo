<?php

declare(strict_types=1);

namespace App\Todo\Application;

use App\Exceptions\DomainInvalidArgumentException;
use App\Todo\Domain\Repository\TodoRepository;

final class AddDeadlineHandler
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
     * @param AddDeadline $addDeadline
     */
    public function handle(AddDeadline $addDeadline): void
    {
        if (null === ($todo = $this->todoRepository->get($addDeadline->todoId()))) {
            throw new DomainInvalidArgumentException(
                sprintf('The todo with id %s does not exist!', (string)$addDeadline->todoId())
            );
        }
        $this->todoRepository->save(
            $todo->addDeadline($addDeadline->userId(), $addDeadline->deadline())
        );
    }
}
