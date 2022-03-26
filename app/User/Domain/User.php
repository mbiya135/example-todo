<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\EventSourcing\AggregateRoot;
use App\Todo\Domain\TodoId;
use App\User\Domain\Event\TodoAttached;
use App\User\Domain\Event\UserAdded;
use Ramsey\Collection\Collection;

final class User extends AggregateRoot
{

    /**
     * @var UserId
     */
    private UserId $userId;

    /**
     * @var UserName
     */
    private UserName $userName;

    /**
     * @var UserPassword
     */
    private UserPassword $userPassword;

    /**
     * @var UserEmail
     */
    private UserEmail $userEmail;

    /**
     * @var Collection
     */
    private Collection $todos;

    /**
     * @param UserId $userId
     * @param UserName $userName
     * @param UserEmail $userEmail
     * @param UserPassword $userPassword
     * @return static
     */
    public static function add(
        UserId $userId,
        UserName $userName,
        UserEmail $userEmail,
        UserPassword $userPassword
    ): self {
        $todo = new self();
        return $todo
            ->loadUuid((string)$userId)
            ->recordThat(
                UserAdded::createFrom(
                    $userId,
                    $userName,
                    $userEmail,
                    $userPassword
                )
            );
    }

    /**
     * @param TodoId $todoId
     * @return $this
     */
    public function attacheTodo(TodoId $todoId): self
    {
        return $this->recordThat(
            TodoAttached::createFrom(
                $this->userId,
                $todoId
            )
        );
    }

    /**
     * @param UserAdded $event
     */
    protected function applyUserAdded(UserAdded $event): void
    {
        $this->userId = $event->userId();
        $this->userName = $event->userName();
        $this->userEmail = $event->userEmail();
        $this->userPassword = $event->userPassword();
        $this->todos = new Collection(TodoId::class, []);
    }

    /**
     * @param TodoAttached $event
     */
    protected function applyTodoAttached(TodoAttached $event): void
    {
        $this->todos->add($event->todoId());
    }

    /**
     * @return string
     */
    public function aggregateId(): string
    {
        return (string)$this->userId;
    }
}
