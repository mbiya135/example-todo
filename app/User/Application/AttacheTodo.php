<?php

declare(strict_types=1);

namespace App\User\Application;

use App\Todo\Domain\TodoId;
use App\User\Domain\UserId;
use Illuminate\Foundation\Bus\Dispatchable;

final class AttacheTodo
{
    use Dispatchable;

    /**
     * @var UserId
     */
    private UserId $userId;

    /**
     * @var TodoId
     */
    private TodoId $todoId;

    /**
     * @param array $payload
     * @return static
     */
    public static function fromPayload(
        array $payload
    ): self {
        return new self(
            UserId::createFromString($payload['user_id']),
            TodoId::createFromString($payload['todo_id']),
        );
    }

    /**
     * @param UserId $userId
     * @param TodoId $todoId
     */
    private function __construct(
        UserId $userId,
        TodoId $todoId
    ) {
        $this->userId = $userId;
        $this->todoId = $todoId;
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
}
