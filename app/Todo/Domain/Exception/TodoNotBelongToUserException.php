<?php

declare(strict_types=1);

namespace App\Todo\Domain\Exception;

use App\Exceptions\DomainInvalidArgumentException;
use App\Todo\Domain\TodoId;
use App\User\Domain\UserId;

final class TodoNotBelongToUserException extends DomainInvalidArgumentException
{

    /**
     * @param TodoId $todoId
     * @return static
     */
    public static function invalidUser(TodoId $todoId, UserId $userId): self
    {
        return new self(
            sprintf(
                'The user with id %s cannot modify Todo (%s) belongs to other user',
                (string)$userId,
                (string)$todoId
            ),
        );
    }
}