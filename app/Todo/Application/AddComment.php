<?php

declare(strict_types=1);

namespace App\Todo\Application;

use App\Todo\Domain\Comment;
use App\Todo\Domain\TodoId;
use App\User\Domain\UserId;
use Illuminate\Foundation\Bus\Dispatchable;

final class AddComment
{
    use Dispatchable;

    /**
     * @param array $payload
     * @return static
     */
    public static function fromPayload(
        array $payload
    ): self {
        return new self(
            TodoId::createFromString($payload['todo_id']),
            Comment::from(
                0,
                $payload['comment'],
                UserId::createFromString($payload['user_id'])
            )
        );
    }

    /**
     * @param TodoId $todoId
     * @param Comment $comment
     */
    private function __construct(
        private TodoId $todoId,
        private Comment $comment
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
     * @return Comment
     */
    public function comment(): Comment
    {
        return $this->comment;
    }


    /**
     * @return string[]
     */
    public static function validation(): array
    {
        return [
            'todo_id' => 'required|uuid',
            'user_id' => 'required|uuid|exists:users,uuid',
            'comment' => 'required|string'
        ];
    }
}
