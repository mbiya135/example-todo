<?php

declare(strict_types=1);

namespace App\Todo\Domain;

use App\User\Domain\UserId;

final class Comment
{
    /**
     * @param int $commentId
     * @param string $comment
     * @param UserId $userId
     * @return static
     */
    public static function from(int $commentId, string $comment, UserId $userId): self
    {
        return new self($commentId, $comment, $userId);
    }

    /**
     * @param int $commentId
     * @param string $comment
     * @param UserId $userId
     */
    private function __construct(
        private int $commentId,
        private string $comment,
        private UserId $userId
    ) {
    }

    /**
     * @return string
     */
    public function comment(): string
    {
        return $this->comment;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    public function commentId(): int
    {
        return $this->commentId;
    }

    /**
     * @param Comment $currentComment
     * @return bool
     */
    public function same(Comment $currentComment): bool
    {
        return $currentComment->commentId === $this->commentId;
    }

    /**
     * @param int $commentId
     * @return $this
     */
    public function withNewId(int $commentId): self
    {
        return new self($commentId, $this->comment, $this->userId);
    }
}
