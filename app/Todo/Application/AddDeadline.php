<?php

declare(strict_types=1);

namespace App\Todo\Application;

use App\Todo\Domain\TodoDeadline;
use App\Todo\Domain\TodoId;
use App\User\Domain\UserId;
use Exception;
use Illuminate\Foundation\Bus\Dispatchable;

final class AddDeadline
{
    use Dispatchable;

    /**
     * @param array $payload
     * @return static
     * @throws Exception
     */
    public static function fromPayload(
        array $payload
    ): self {
        return new self(
            TodoId::createFromString($payload['todo_id']),
            TodoDeadline::fromString($payload['deadline']),
            UserId::createFromString($payload['user_id'])
        );
    }

    /**
     * @param TodoId $todoId
     * @param TodoDeadline $deadline
     * @param UserId $userId
     */
    private function __construct(
        private TodoId $todoId,
        private TodoDeadline $deadline,
        private UserId $userId
    ) {
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
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return string[]
     */
    public static function validation(): array
    {
        return [
            'todo_id' => 'required|uuid',
            'user_id' => 'required|uuid|exists:users,uuid',
            'deadline' => 'required|date'
        ];
    }
}
