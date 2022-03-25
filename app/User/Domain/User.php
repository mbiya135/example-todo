<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\User\Domain\Event\UserAdded;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

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
     * @param UserAdded $event
     */
    protected function applyUserAdded(UserAdded $event): void
    {
        $this->userId = $event->userId();
        $this->userName = $event->userName();
        $this->userEmail = $event->userEmail();
        $this->userPassword = $event->userPassword();
    }
}