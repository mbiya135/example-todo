<?php

declare(strict_types=1);

namespace App\Todo\Domain;

// @codingStandardsIgnoreStart
enum TodoStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';

    /**
     * @return string
     */
    public function status(): string
    {
        return match ($this) {
            self::OPEN => 'open',
            self::IN_PROGRESS => 'in_progress',
            self::DONE => 'done',
        };
    }
}
