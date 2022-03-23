<?php

declare(strict_types=1);

namespace App\Todo\Domain\Event;

use App\Todo\Domain\TodoDescription;
use App\Todo\Domain\TodoId;
use App\User\Domain\UserId;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

final class TodoAdded extends ShouldBeStored
{
    /**
     * @var TodoId
     */
    public TodoId $todoId;

    /**
     * @var TodoDescription
     */
    public TodoDescription $todoDescription;

    /**
     * @var UserId
     */
    public UserId $userId;

    /**
     * @param TodoId $todoId
     * @param TodoDescription $todoDescription
     * @param UserId $userId
     * @return static
     */
    public static function createFrom(
        TodoId $todoId,
        TodoDescription $todoDescription,
        UserId $userId
    ): self {
        return new self(
            $todoId,
            $todoDescription,
            $userId
        );
    }

    /**
     * @param TodoId $todoId
     * @param TodoDescription $todoDescription
     * @param UserId $userId
     */
    private function __construct(
        TodoId $todoId,
        TodoDescription $todoDescription,
        UserId $userId
    ) {
        $this->todoId = $todoId;
        $this->todoDescription = $todoDescription;
        $this->userId = $userId;
    }

    /**
     * @return TodoId
     */
    public function todoId(): TodoId
    {
        return $this->todoId;
    }

    /**
     * @return TodoDescription
     */
    public function todoDescription(): TodoDescription
    {
        return $this->todoDescription;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'description' => $this->todoDescription->__toString(),
        ];
    }
}