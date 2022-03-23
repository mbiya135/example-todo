<?php

declare(strict_types=1);

namespace App\User\Domain;

final class UserName
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @param string $name
     * @return static
     */
    public static function createFromString(string $name): self
    {
        return new self($name);
    }

    /**
     * @param string $name
     */
    private function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->name;
    }

    /**
     * @param UserName $userName
     * @return bool
     */
    public function sameAs(UserName $userName): bool
    {
        return $userName->name === $this->name;
    }
}