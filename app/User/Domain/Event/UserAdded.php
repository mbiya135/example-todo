<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\EventSourcing\ShouldBeStored;
use App\User\Domain\UserEmail;
use App\User\Domain\UserId;
use App\User\Domain\UserName;
use App\User\Domain\UserPassword;

final class UserAdded extends ShouldBeStored
{

    /**
     * @param UserId $userId
     * @param UserName $userName
     * @param UserEmail $userEmail
     * @param UserPassword $userPassword
     * @return static
     */
    public static function createFrom(
        UserId $userId,
        UserName $userName,
        UserEmail $userEmail,
        UserPassword $userPassword,
    ): self {
        return new self(
            $userId,
            $userName,
            $userEmail,
            $userPassword
        );
    }

    /**
     * @param UserId $userId
     * @param UserName $userName
     * @param UserEmail $userEmail
     * @param UserPassword $userPassword
     * @param array|null $metadata
     */
    private function __construct(
        private UserId $userId,
        private UserName $userName,
        private UserEmail $userEmail,
        private UserPassword $userPassword,
        ?array $metadata = []
    ) {
        $this->metaData = $metadata;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return UserName
     */
    public function userName(): UserName
    {
        return $this->userName;
    }

    /**
     * @return UserPassword
     */
    public function userPassword(): UserPassword
    {
        return $this->userPassword;
    }

    /**
     * @return UserEmail
     */
    public function userEmail(): UserEmail
    {
        return $this->userEmail;
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            'user_id' => (string)$this->userId,
            'user_name' => (string)$this->userName,
            'user_email' => (string)$this->userEmail,
            'user_password' => (string)$this->userPassword,
        ];
    }

    /**
     * @param array $data
     * @param array $metadata
     * @return ShouldBeStored
     */
    public static function fromArray(array $data, array $metadata): ShouldBeStored
    {
        return new self(
            UserId::createFromString($data['user_id']),
            UserName::createFromString($data['user_name']),
            UserEmail::createFromString($data['user_email']),
            UserPassword::createFromString($data['user_password']),
            $metadata
        );
    }
}
