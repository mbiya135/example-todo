<?php

declare(strict_types=1);

namespace App\Todo\Domain;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;

final class TodoDeadline
{
    /**
     * @param string $deadline
     * @return static
     * @throws Exception
     */
    public static function fromString(string $deadline): self
    {
        return new self(new DateTimeImmutable($deadline, new \DateTimeZone('UTC')));
    }

    /**
     * @param DateTimeImmutable $deadline
     */
    private function __construct(private DateTimeImmutable $deadline)
    {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->deadline->format(DateTimeInterface::ATOM);
    }

    /**
     * @return DateTimeImmutable
     */
    public function dateTime(): DateTimeImmutable
    {
        return $this->deadline;
    }

    /**
     * @param TodoDeadline $deadline
     * @return bool
     */
    public function sameAs(TodoDeadline $deadline): bool
    {
        return $deadline->deadline === $this->deadline;
    }
}
