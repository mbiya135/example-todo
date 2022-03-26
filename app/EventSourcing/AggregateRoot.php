<?php

declare(strict_types=1);

namespace App\EventSourcing;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Spatie\EventSourcing\StoredEvents\StoredEvent;

abstract class AggregateRoot extends \Spatie\EventSourcing\AggregateRoots\AggregateRoot
{

    /**
     * @var string
     */
    private string $uuid = '';

    /**
     * @param string $uuid
     * @return $this
     */
    public function loadUuid(string $uuid): static
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    abstract public function aggregateId(): string;

    /**
     * @param ShouldBeStored[] $events
     * @return $this
     */
    public function reconstituteFromDatabaseEvents(array $events): static
    {
        $events = collect($events);
        $events->each(function (StoredEvent $storedEvent) {
            $this->apply($storedEvent->event);
        });
        $this->aggregateVersionAfterReconstitution = $this->aggregateVersion;

        return $this;
    }
}
