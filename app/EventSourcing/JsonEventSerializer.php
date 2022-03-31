<?php

declare(strict_types=1);

namespace App\EventSourcing;

use Carbon\CarbonImmutable;
use RuntimeException;
use Spatie\EventSourcing\Enums\MetaData;
use Spatie\EventSourcing\EventSerializers\EventSerializer;

class JsonEventSerializer implements EventSerializer
{

    /**
     * @param ShouldBeStored|\Spatie\EventSourcing\StoredEvents\ShouldBeStored $event
     * @return string
     */
    public function serialize(ShouldBeStored|\Spatie\EventSourcing\StoredEvents\ShouldBeStored $event): string
    {
        return json_encode($event->toArray());
    }

    /**
     * @param string $eventClass
     * @param string $json
     * @param int $version
     * @param string|null $metadata
     * @return ShouldBeStored
     */
    public function deserialize(string $eventClass, string $json, int $version, string $metadata = null): ShouldBeStored
    {
        if (!method_exists($eventClass, 'fromArray')) {
            throw new RuntimeException(sprintf('The method "$eventClass" does not exist in command %s!', $eventClass));
        }

        $metadata = json_decode($metadata, true);

        return $eventClass::fromArray(
            json_decode($json, true),
            [
                MetaData::CREATED_AT => CarbonImmutable::make($metadata['created-at']),
                MetaData::AGGREGATE_ROOT_UUID => $metadata['aggregate-root-uuid'],
                MetaData::STORED_EVENT_ID => $metadata['stored-event-id'],
                MetaData::AGGREGATE_ROOT_VERSION => $metadata['aggregate-root-version'],
            ]
        );
    }
}
