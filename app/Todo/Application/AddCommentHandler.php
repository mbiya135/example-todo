<?php

declare(strict_types=1);

namespace App\Todo\Application;

use App\Exceptions\DomainInvalidArgumentException;
use App\Todo\Domain\Repository\TodoRepository;

final class AddCommentHandler
{

    /**
     * @param TodoRepository $todoRepository
     */
    public function __construct(private TodoRepository $todoRepository)
    {
    }

    /**
     * @param AddComment $addComment
     */
    public function handle(AddComment $addComment): void
    {
        if (null === ($todo = $this->todoRepository->get($addComment->todoId()))) {
            throw new DomainInvalidArgumentException(
                sprintf('The todo with id %s does not exist!', (string)$addComment->todoId())
            );
        }
        $this->todoRepository->save(
            $todo->addComment($addComment->comment())
        );
    }
}
