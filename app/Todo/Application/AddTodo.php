<?php

declare(strict_types=1);

namespace App\Todo\Application;

use App\Todo\Domain\TodoDescription;
use App\Todo\Domain\TodoId;
use App\User\Domain\UserId;
use Illuminate\Foundation\Bus\Dispatchable;

final class AddTodo
{
    use Dispatchable;

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
     * @param array $payload
     * @return static
     */
    public static function fromPayload(
        array $payload
    ): self {
        return new self(
            TodoId::createFromString($payload['todo_id']),
            TodoDescription::createFromString($payload['todo_description']),
            UserId::createFromString($payload['user_id']),
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

    /**
     * @return string[]
     */
    public static function validation(): array
    {
        return [
            'todo_id' => 'required|uuid|unique:todos,uuid',
            'user_id' => 'required|uuid|exists:users,uuid',
            'todo_description' => 'required|string'
        ];
    }
}
