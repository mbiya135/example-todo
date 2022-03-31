<?php

declare(strict_types=1);

namespace App\EventSourcing;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

final class AggregateRootEntity extends AggregateRoot
{

    /**
     * @return int
     */
    public function aggregateVersionAfterReconstitution(): int
    {
        return $this->aggregateVersionAfterReconstitution;
    }
}
