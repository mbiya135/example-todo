<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\User;
use App\User\Domain\UserId;

interface UserRepository
{
    /**
     * @param UserId $userId
     * @return User|null
     */
    public function get(UserId $userId): ?User;

    /**
     * @param User $user
     */
    public function save(User $user): void;
}
