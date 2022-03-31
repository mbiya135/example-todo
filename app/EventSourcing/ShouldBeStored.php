<?php

declare(strict_types=1);

namespace App\EventSourcing;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored as SpatieShouldBeStored;

abstract class ShouldBeStored extends SpatieShouldBeStored
{
    /**
     * @return array
     */
    abstract public function toArray(): array;

    /**
     * @param array $data
     * @param array $metadata
     * @return ShouldBeStored
     */
    abstract public static function fromArray(array $data, array $metadata): ShouldBeStored;
}
