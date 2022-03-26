<?php

declare(strict_types=1);

namespace App\User\Domain;

final class UserEmail
{
    /**
     * @var string
     */
    private string $userEmail;

    /**
     * @param string $userEmail
     * @return static
     */
    public static function createFromString(string $userEmail): self
    {
        return new self($userEmail);
    }

    /**
     * @param string $userEmail
     */
    private function __construct(string $userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->userEmail;
    }

    /**
     * @param UserEmail $userEmail
     * @return bool
     */
    public function sameAs(UserEmail $userEmail): bool
    {
        return $userEmail->userEmail === $this->userEmail;
    }
}
