<?php

declare(strict_types=1);

namespace App\Email\Infrastructure;

use App\EventSourcing\EventStoreRepository;
use App\Models\Email;
use App\Todo\Domain\Repository\TodoRepository as TodoRepositoryDomain;
use App\Todo\Domain\Todo;
use App\Todo\Domain\TodoId;

interface ProviderEmailApi
{
    /**
     * @param Email $email
     */
    public function sendEmail(Email $email): void;

    /**
     * @param Email $email
     * @return string
     */
    public function getEmailStatus(Email $email): string;

    /**
     * @return array
     */
    public function getAllMessage(): array;
}
