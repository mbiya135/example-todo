<?php

declare(strict_types=1);

namespace App\Todo\Domain\Event;

use App\Todo\Domain\TodoDescription;
use App\Todo\Domain\TodoId;
use App\User\Domain\UserId;
use App\EventSourcing\ShouldBeStored;
use JetBrains\PhpStorm\ArrayShape;

final class TodoUpdated extends ShouldBeStored
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
     * @param TodoId $todoId
     * @param TodoDescription $todoDescription
     * @return static
     */
    public static function createFrom(
        TodoId $todoId,
        TodoDescription $todoDescription,
    ): self {
        return new self(
            $todoId,
            $todoDescription,
        );
    }

    /**
     * @param TodoId $todoId
     * @param TodoDescription $todoDescription
     * @param array|null $metadata
     */
    private function __construct(
        TodoId $todoId,
        TodoDescription $todoDescription,
        ?array $metadata = []
    ) {
        $this->todoId = $todoId;
        $this->todoDescription = $todoDescription;
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
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            'todo_id' => (string)$this->todoId,
            'description' => (string)$this->todoDescription,
        ];
    }

    /**
     * @param array $data
     * @param array $metadata
     * @return ShouldBeStored
     */
    public static function fromArray(array $data, array $metadata): ShouldBeStored
    {
        return new self(
            TodoId::createFromString($data['todo_id']),
            TodoDescription::createFromString($data['description']),
            $metadata
        );
    }
}