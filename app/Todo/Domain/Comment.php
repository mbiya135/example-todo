<?php

declare(strict_types=1);

namespace App\Todo\Domain;

use App\User\Domain\UserId;

final class Comment
{
    /**
     * @var string
     */
    private string $comment;

    /**
     * @var UserId
     */
    private UserId $userId;

    /**
     * @param string $comment
     * @param UserId $userId
     * @return static
     */
    public static function from(string $comment, UserId $userId): self
    {
        return new self($comment, $userId);
    }

    /**
     * @param string $comment
     * @param UserId $userId
     */
    private function __construct(string $comment, UserId $userId)
    {
        $this->comment = $comment;
        $this->userId = $userId;
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

    /**
     * @param Comment $comment
     * @return bool
     */
    public function sameAs(Comment $comment): bool
    {
        return $comment->comment === $this->comment && $this->userId->sameAs($comment->userId);
    }
}
