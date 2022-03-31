<?php

declare(strict_types=1);

namespace App\EventSourcing;

abstract class EventStoreRepository
{

    /**
     * @param AggregateRoot $aggregateRoot
     */
    public function persist(AggregateRoot $aggregateRoot): void
    {
        $aggregateRootEntity = AggregateRootEntity::retrieve($aggregateRoot->aggregateId());
        foreach ($aggregateRoot->getRecordedEvents() as $event) {
            if ($event->eventVersion() > $aggregateRootEntity->aggregateVersionAfterReconstitution()) {
                $aggregateRootEntity->recordThat(
                    $event
                );
            }
        }
        $aggregateRootEntity->persist();
    }

    /**
     * @param AggregateRoot $aggregateRoot
     * @return AggregateRoot
     */
    public function reconstituteFromDatabaseEvents(AggregateRoot $aggregateRoot): AggregateRoot
    {
        $aggregateRootEntity = AggregateRootEntity::retrieve($aggregateRoot->uuid());
        $aggregateRoot->reconstituteFromDatabaseEvents($aggregateRootEntity->getRecordedEvents());
        return $aggregateRoot;
    }
}
