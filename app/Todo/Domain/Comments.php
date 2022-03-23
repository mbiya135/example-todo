<?php

declare(strict_types=1);

namespace App\Todo\Domain;

use App\User\Domain\UserId;
use ArrayIterator;
use Countable;

final class Comments implements Countable
{

    /**
     * @var Comment[]
     */
    private array $comments;

    /**
     * @return Comment[]
     */
    public function getIterator(): iterable
    {
        return new ArrayIterator($this->comments);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->comments);
    }

    /**
     * @param Comments[] $comments
     * @return Comments
     */
    public static function fromArray(array $comments): self
    {
        return new self(
            ...array_map(
                   fn(array $comment): Comment => Comment::from(
                       $comment['comment'],
                       UserId::createFromString($comment['user_id'])
                   ),
                   $comments
               )
        );
    }

    /**
     * @param Comment ...$comments
     * @return static
     */
    public static function fromComments(Comment ...$comments): self
    {
        return new self(...$comments);
    }

    /**
     * @return Comments
     */
    public static function emptyList(): self
    {
        return new self();
    }

    /**
     * @param Comment ...$comments
     */
    private function __construct(Comment ...$comments)
    {
        $this->comments = $comments;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function push(Comment $comment): self
    {
        $copy = clone $this;
        $copy->comments[] = $comment;
        return $copy;
    }

    /**
     * @return Comments
     */
    public function pop(): self
    {
        $copy = clone $this;
        array_pop($copy->comments);
        return $copy;
    }

    /**
     * @param Comment $comment
     * @return bool
     */
    public function contains(Comment $comment): bool
    {
        return (bool)array_filter(
            $this->comments,
            fn(Comment $currentComment) => $comment->sameAs($comment)
        );
    }

    /**
     * @return Comment[]
     */
    public function toArray(): array
    {
        return $this->comments;
    }
}
