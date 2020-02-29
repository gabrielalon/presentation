<?php

namespace App\Modules\Message\Integration;

use App\Libraries\Messaging\Aggregate\AggregateChanged;
use App\Libraries\Messaging\Aggregate\AggregateId;
use App\Libraries\Messaging\Event\EventStreamRepository;
use App\Modules\Message\DomainModel\Entity\EventStreamEntity;
use App\Modules\Message\DomainModel\Service\Serializer;

class EventStreamEloquentRepository implements EventStreamRepository
{
    /** @var Serializer */
    private $serializer;

    /**
     * EventStreamEloquentRepository constructor.
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function save(AggregateChanged $event): void
    {
        $entity = new EventStreamEntity($this->extractCreateData($event));
        $entity->save();
    }

    /**
     * @param AggregateChanged $event
     * @return array
     */
    private function extractCreateData(AggregateChanged $event): array
    {
        return [
            'event_uuid' => $event->aggregateId(),
            'event_name' => $event->eventName(),
            'version' => $event->version(),
            'payload' => $this->serializer->encode($event->payload()),
            'user_id' => auth()->check() ? auth()->user()->getAuthIdentifier() : null
        ];
    }

    /**
     * @inheritDoc
     */
    public function load(AggregateId $aggregateId, int $lastVersion): array
    {
        $collection = EventStreamEntity::query()
            ->where(['event_uuid' => $aggregateId->toString()])
            ->where('version', '>=', $lastVersion)
            ->get();

        if ($collection->count() === 0) {
            return [];
        }

        $stream = [];

        /** @var EventStreamEntity $entity */
        foreach ($collection as $entity) {
            /** @var AggregateChanged $event */
            $event = $entity->event_name;
            $event = $event::occur($entity->event_uuid, $this->serializer->decode($entity->payload));

            $stream[] = $event->withVersion($entity->version);
        }

        return $stream;
    }
}
