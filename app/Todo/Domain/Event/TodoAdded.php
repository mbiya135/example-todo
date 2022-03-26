<?php

declare(strict_types=1);

namespace App\Todo\Domain\Event;

use App\EventSourcing\ShouldBeStored;
use App\Todo\Domain\TodoDescription;
use App\Todo\Domain\TodoId;
use App\User\Domain\UserId;

final class TodoAdded extends ShouldBeStored
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
     * @param array|null $metadata
     */
    private function __construct(
        TodoId $todoId,
        TodoDescription $todoDescription,
        UserId $userId,
        ?array $metadata = []
    ) {
        $this->todoId = $todoId;
        $this->todoDescription = $todoDescription;
        $this->userId = $userId;
        $this->metaData = $metadata;
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

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            'todo_id' => (string)$this->todoId,
            'user_id' => (string)$this->userId,
            'description' => (string)$this->todoDescription,
        ];
    }

    /**
     * @param array $data
     * @return ShouldBeStored|TodoAdded
     */
    public static function fromArray(array $data, array $metadata): ShouldBeStored|TodoAdded
    {
        return new self(
            TodoId::createFromString($data['todo_id']),
            TodoDescription::createFromString($data['description']),
            UserId::createFromString($data['user_id']),
            $metadata
        );
    }
}
