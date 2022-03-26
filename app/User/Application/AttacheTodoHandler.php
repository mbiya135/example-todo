<?php

declare(strict_types=1);

namespace App\User\Application;

use App\Exceptions\DomainInvalidArgumentException;
use App\User\Domain\Repository\UserRepository;

final class AttacheTodoHandler
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
     * @param AttacheTodo $attacheTodo
     */
    public function handle(AttacheTodo $attacheTodo): void
    {
        if (null === ($user = $this->userRepository->get($attacheTodo->userId()))) {
            throw new DomainInvalidArgumentException(
                sprintf('User with id %s does not exist!', (string)$attacheTodo->userId())
            );
        }
        $this->userRepository->save(
            $user->attacheTodo($attacheTodo->todoId())
        );
    }
}
