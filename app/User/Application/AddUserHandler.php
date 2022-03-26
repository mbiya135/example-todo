<?php

declare(strict_types=1);

namespace App\User\Application;

use App\Exceptions\DomainInvalidArgumentException;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\User;

final class AddUserHandler
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param AddUser $addUser
     */
    public function handle(AddUser $addUser): void
    {
        if ($this->userRepository->get($addUser->userId())) {
            throw new DomainInvalidArgumentException(
                sprintf('User with id %s already exist!', (string)$addUser->userId())
            );
        }
        $this->userRepository->save(
            User::add(
                $addUser->userId(),
                $addUser->userName(),
                $addUser->email(),
                $addUser->password(),
            )
        );
    }
}
