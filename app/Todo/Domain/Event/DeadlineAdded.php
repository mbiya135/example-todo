<?php

declare(strict_types=1);

namespace App\Todo\Domain\Event;

use App\EventSourcing\ShouldBeStored;
use App\Todo\Domain\TodoDeadline;
use App\Todo\Domain\TodoId;
use Exception;

final class DeadlineAdded extends ShouldBeStored
{
    /**
     * @var TodoId
     */
    private TodoId $todoId;

    /**
     * @var TodoDeadline
     */
    private TodoDeadline $deadline;

    /**
     * @param TodoId $todoId
     * @param TodoDeadline $deadline
     * @return static
     */
    public static function createFrom(
        TodoId $todoId,
        TodoDeadline $deadline,
    ): self {
        return new self(
            $todoId,
            $deadline
        );
    }

    /**
     * @param TodoId $todoId
     * @param TodoDeadline $deadline
     * @param array|null $metadata
     */
    private function __construct(
        TodoId $todoId,
        TodoDeadline $deadline,
        ?array $metadata = []
    ) {
        $this->todoId = $todoId;
        $this->deadline = $deadline;
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
     * @return TodoDeadline
     */
    public function deadline(): TodoDeadline
    {
        return $this->deadline;
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            'todo_id' => (string)$this->todoId,
            'deadline' => (string)$this->deadline,
        ];
    }

    /**
     * @param array $data
     * @param array $metadata
     * @return ShouldBeStored|DeadlineAdded
     * @throws Exception
     */
    public static function fromArray(array $data, array $metadata): ShouldBeStored|DeadlineAdded
    {
        return new self(
            TodoId::createFromString($data['todo_id']),
            TodoDeadline::fromString($data['deadline']),
            $metadata
        );
    }
}
