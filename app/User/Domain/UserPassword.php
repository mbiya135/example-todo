<?php

declare(strict_types=1);

namespace App\User\Domain;

final class UserPassword
{
    /**
     * @var string
     */
    private string $password;

    /**
     * @param string $password
     * @return static
     */
    public static function createFromString(string $password): self
    {
        return new self($password);
    }

    /**
     * @param string $password
     */
    private function __construct(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->password;
    }

    /**
     * @param UserPassword $password
     * @return bool
     */
    public function sameAs(UserPassword $password): bool
    {
        return $password->password === $this->password;
    }
}
