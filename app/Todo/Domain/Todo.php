<?php

declare(strict_types=1);

namespace App\Todo\Domain;

use App\Todo\Domain\Event\TodoAdded;
use App\User\Domain\UserId;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

final class Todo extends AggregateRoot
{
    /**
     * @var TodoId
     */
    private TodoId $todoId;

    /**
     * @var TodoDescription
     */
    private TodoDescription $todoDescription;

    /**
     * @var UserId
     */
    private UserId $userId;

    /**
     * @var TodoStatus
     */
    private TodoStatus $todoStatus;

    /**
     * @var Comments
     */
    private Comments $comments;

    /**
     * @param TodoDescription $todoDescription
     * @param UserId $userId
     * @return static
     */
    public static function add(
        TodoId $todoId,
        TodoDescription $todoDescription,
        UserId $userId,
    ): self {
        $todo = new self();
        return $todo
            ->loadUuid((string)$todoId)
            ->recordThat(
                TodoAdded::createFrom(
                    TodoId::createFromString($todo->uuid()),
                    $todoDescription,
                    $userId
                )
            );
    }
}