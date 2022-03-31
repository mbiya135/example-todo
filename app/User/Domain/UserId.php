<?php

declare(strict_types=1);

namespace App\User\Domain;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UserId
{
    /**
     * @param string $uuid
     * @return static
     */
    public static function createFromString(string $uuid): self
    {
        return new self(Uuid::fromString($uuid));
    }

    /**
     * @param UuidInterface $uuid
     */
    private function __construct(private UuidInterface $uuid)
    {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    /**
     * @param UserId $todoId
     * @return bool
     */
    public function sameAs(UserId $todoId): bool
    {
        return $this->uuid->equals($todoId->uuid);
    }
}
