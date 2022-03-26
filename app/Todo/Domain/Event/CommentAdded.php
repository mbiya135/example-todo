<?php

declare(strict_types=1);

namespace App\Todo\Domain\Event;

use App\EventSourcing\ShouldBeStored;
use App\Todo\Domain\Comment;
use App\Todo\Domain\TodoId;
use App\User\Domain\UserId;

final class CommentAdded extends ShouldBeStored
{
    /**
     * @var TodoId
     */
    private TodoId $todoId;

    /**
     * @var Comment
     */
    private Comment $comment;

    /**
     * @param TodoId $todoId
     * @param Comment $comment
     * @return static
     */
    public static function createFrom(
        TodoId $todoId,
        Comment $comment,
    ): self {
        return new self(
            $todoId,
            $comment
        );
    }

    /**
     * @param TodoId $todoId
     * @param Comment $comment
     * @param array|null $metadata
     */
    private function __construct(
        TodoId $todoId,
        Comment $comment,
        ?array $metadata = []
    ) {
        $this->todoId = $todoId;
        $this->comment = $comment;
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
     * @return Comment
     */
    public function comment(): Comment
    {
        return $this->comment;
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            'todo_id' => (string)$this->todoId,
            'comment_id' => $this->comment->commentId(),
            'user_id' => (string)$this->comment->userId(),
            'comment' => $this->comment->comment(),
        ];
    }

    /**
     * @param array $data
     * @param array $metadata
     * @return ShouldBeStored|CommentAdded
     */
    public static function fromArray(array $data, array $metadata): ShouldBeStored|CommentAdded
    {
        return new self(
            TodoId::createFromString($data['todo_id']),
            Comment::from(
                $data['comment_id'],
                $data['comment'],
                UserId::createFromString($data['user_id'])
            ),
            $metadata
        );
    }
}
