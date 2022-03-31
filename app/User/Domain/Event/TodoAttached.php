<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\EventSourcing\ShouldBeStored;
use App\Todo\Domain\TodoId;
use App\User\Domain\UserId;

final class TodoAttached extends ShouldBeStored
{
    /**
     * @var UserId
     */
    private UserId $userId;

    /**
     * @var TodoId
     */
    private TodoId $todoId;

    /**
     * @param UserId $userId
     * @param TodoId $todoId
     * @return static
     */
    public static function createFrom(
        UserId $userId,
        TodoId $todoId,
    ): self {
        return new self(
            $userId,
            $todoId,
        );
    }

    /**
     * @param UserId $userId
     * @param TodoId $todoId
     * @param array|null $metadata
     */
    private function __construct(
        UserId $userId,
        TodoId $todoId,
        ?array $metadata = []
    ) {
        $this->userId = $userId;
        $this->todoId = $todoId;
        $this->metaData = $metadata;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return TodoId
     */
    public function todoId(): TodoId
    {
        return $this->todoId;
    }


    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            'user_id' => (string)$this->userId,
            'todo_id' => (string)$this->todoId,
        ];
    }

    /**
     * @param array $data
     * @param array $metadata
     * @return ShouldBeStored|TodoAttached
     */
    public static function fromArray(array $data, array $metadata): ShouldBeStored|TodoAttached
    {
        return new self(
            UserId::createFromString($data['user_id']),
            TodoId::createFromString($data['todo_id']),
            $metadata
        );
    }
}
