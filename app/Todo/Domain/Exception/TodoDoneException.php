<?php

declare(strict_types=1);

namespace App\Todo\Domain\Exception;

use App\Exceptions\DomainInvalidArgumentException;
use App\Todo\Domain\TodoId;

final class TodoDoneException extends DomainInvalidArgumentException
{
    /**
     * @param TodoId $todoId
     * @return static
     */
    public static function alreadyDone(TodoId $todoId): self
    {
        return new self(
            sprintf(
                'Cannot modify Todo (with id %s) marked as done',
                (string)$todoId
            )
        );
    }
}