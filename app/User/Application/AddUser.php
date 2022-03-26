<?php

declare(strict_types=1);

namespace App\User\Application;

use App\User\Domain\UserEmail;
use App\User\Domain\UserId;
use App\User\Domain\UserName;
use App\User\Domain\UserPassword;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Hash;

final class AddUser
{
    use Dispatchable;

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
    private UserPassword $password;

    /**
     * @var UserEmail
     */
    private UserEmail $email;

    /**
     * @param array $payload
     * @return static
     */
    public static function fromPayload(
        array $payload
    ): self {
        return new self(
            UserId::createFromString($payload['user_id']),
            UserName::createFromString($payload['user_name']),
            UserEmail::createFromString($payload['user_email']),
            UserPassword::createFromString(Hash::make($payload['user_password'])),
        );
    }

    /**
     * @param UserId $userId
     * @param UserName $userName
     * @param UserEmail $userEmail
     * @param UserPassword $userPassword
     */
    private function __construct(
        UserId $userId,
        UserName $userName,
        UserEmail $userEmail,
        UserPassword $userPassword,
    ) {
        $this->userId = $userId;
        $this->userName = $userName;
        $this->password = $userPassword;
        $this->email = $userEmail;
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
    public function password(): UserPassword
    {
        return $this->password;
    }

    /**
     * @return UserEmail
     */
    public function email(): UserEmail
    {
        return $this->email;
    }

    /**
     * @return string[]
     */
    public static function validation(): array
    {
        return [
            'user_id' => 'required|uuid|unique:users,uuid',
            'user_name' => 'required|string',
            'user_email' => 'required|email|unique:users,email',
            'user_password' => 'required|string',
        ];
    }
}
