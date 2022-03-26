<?php

declare(strict_types=1);

namespace App\Todo\Domain;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class TodoId
{
    /**
     * @var UuidInterface
     */
    private UuidInterface $uuid;

    /**
     * @param string $uuid
     * @return static
     */
    public static function createFromString(string $uuid): self
    {
        return new self(Uuid::fromString($uuid));
    }

    /**
     * @return static
     */
    public static function generateUuid(): self
    {
        return new self(Uuid::uuid4());
    }

    /**
     * @param UuidInterface $uuid
     */
    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    /**
     * @param TodoId $todoId
     * @return bool
     */
    public function sameAs(TodoId $todoId): bool
    {
        return $this->uuid->equals($todoId->uuid);
    }
}
