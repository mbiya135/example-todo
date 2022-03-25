<?php

declare(strict_types=1);

namespace App\Todo\Domain;

use App\Todo\Domain\Event\CommentAdded;
use App\Todo\Domain\Event\DeadlineAdded;
use App\Todo\Domain\Event\TodoAdded;
use App\Todo\Domain\Event\TodoUpdated;
use App\Todo\Domain\Exception\TodoDoneException;
use App\Todo\Domain\Exception\TodoNotBelongToUserException;
use App\User\Domain\UserId;
use Illuminate\Support\Collection;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

final class Todo extends AggregateRoot
{
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
     * @var TodoStatus
     */
    private TodoStatus $todoStatus;

    /**
     * @var Collection
     */
    private Collection $comments;

    /**
     * @param TodoId $todoId
     * @param TodoDescription $todoDescription
     * @param UserId $userId
     * @return static
     */
    public static function add(
        TodoId $todoId,
        TodoDescription $todoDescription,
        UserId $userId,
    ): self {
        $todo = new self();
        return $todo
            ->loadUuid((string)$todoId)
            ->recordThat(
                TodoAdded::createFrom(
                    TodoId::createFromString($todo->uuid()),
                    $todoDescription,
                    $userId
                )
            );
    }

    /**
     * @param TodoDescription $todoDescription
     * @return $this
     */
    public function update(TodoDescription $todoDescription): self
    {
        $this->recordThat(
            TodoUpdated::createFrom(
                $this->todoId,
                $todoDescription
            )
        );
        return $this;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function addComment(Comment $comment): self
    {
        // Get max comment id
        $maxId = $this
            ->comments
            ->map(fn(Comment $comment) => $comment->commentId())
            ->max();

        $comment = $comment->withNewId(++$maxId);
        $this->recordThat(
            CommentAdded::createFrom(
                $this->todoId,
                $comment
            )
        );
        return $this;
    }

    /**
     * @param UserId $userId
     * @param TodoDeadline $deadline
     * @return $this
     */
    public function addDeadline(UserId $userId, TodoDeadline $deadline): self
    {
        // Verify user owned the Todo
        if (!$this->userId->sameAs($userId)) {
            throw TodoNotBelongToUserException::invalidUser($this->todoId, $this->userId);
        }
        // Cannot modify Todo marked as done
        if ($this->todoStatus === TodoStatus::DONE) {
            throw TodoDoneException::alreadyDone($this->todoId);
        }
        $this->recordThat(
            DeadlineAdded::createFrom(
                $this->todoId,
                $deadline
            )
        );
        return $this;
    }

    /**
     * @param TodoAdded $event
     */
    protected function applyTodoAdded(TodoAdded $event): void
    {
        $this->todoId = $event->todoId();
        $this->todoDescription = $event->todoDescription();
        $this->userId = $event->userId();
        $this->todoStatus = TodoStatus::OPEN;
        $this->comments = collect([]);
    }

    /**
     * @param TodoUpdated $event
     */
    protected function applyTodoUpdated(TodoUpdated $event): void
    {
        $this->todoDescription = $event->todoDescription();
    }

    /**
     * @param CommentAdded $event
     */
    protected function applyCommentAdded(CommentAdded $event): void
    {
        $this->comments->push($event->comment());
    }

    /**
     * @return TodoDescription
     */
    public function todoDescription(): TodoDescription
    {
        return $this->todoDescription;
    }
}