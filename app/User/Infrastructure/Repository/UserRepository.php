<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Repository;

use App\User\Domain\Repository\UserRepository as TodoRepositoryDomain;
use App\User\Domain\User;
use App\User\Domain\UserId;

final class UserRepository implements TodoRepositoryDomain
{
    /**
     * @param UserId $userId
     * @return User|null
     */
    public function get(UserId $userId): ?User
    {
        $user = User::retrieve((string)$userId);
        return $user->getAppliedEvents() ? $user : null;
    }

    /**
     * @param User $user
     */
    public function save(User $user): void
    {
        $user->persist();
    }
}
