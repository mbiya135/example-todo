<?php

declare(strict_types=1);

namespace App\Todo\Domain;

final class TodoDescription
{
    /**
     * @param string $description
     * @return static
     */
    public static function createFromString(string $description): self
    {
        return new self($description);
    }

    /**
     * @param string $description
     */
    private function __construct(private string $description)
    {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->description;
    }

    /**
     * @param TodoDescription $todoDescription
     * @return bool
     */
    public function sameAs(TodoDescription $todoDescription): bool
    {
        return $todoDescription->description === $this->description;
    }
}
