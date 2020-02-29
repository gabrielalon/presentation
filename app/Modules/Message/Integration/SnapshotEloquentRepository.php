<?php

namespace App\Modules\Message\Integration;

use App\Libraries\Messaging\Aggregate\AggregateId;
use App\Libraries\Messaging\Aggregate\AggregateRoot;
use App\Libraries\Messaging\Snapshot\Snapshot;
use App\Libraries\Messaging\Snapshot\SnapshotRepository;
use App\Modules\Message\DomainModel\Entity\SnapshotEntity;
use App\Modules\Message\Infrastructure\Service\CallbackSerializer;

class SnapshotEloquentRepository implements SnapshotRepository
{
    /** @var CallbackSerializer */
    private $serializer;

    /**
     * SnapshotEloquentRepository constructor.
     * @param CallbackSerializer $serializer
     */
    public function __construct(CallbackSerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function save(Snapshot $snapshot): void
    {
        SnapshotEntity::query()->updateOrCreate($this->extractCreateData($snapshot), [
            'last_version' => $snapshot->lastVersion(),
            'aggregate' => $this->serializer->serialize($snapshot->aggregateRoot())
        ]);
    }

    /**
     * @param Snapshot $snapshot
     * @return array
     */
    private function extractCreateData(Snapshot $snapshot): array
    {
        return [
            'aggregate_uuid' => $snapshot->aggregateRoot()->aggregateId(),
            'aggregate_type' => $snapshot->aggregateType()
        ];
    }

    /**
     * @inheritDoc
     */
    public function get(string $aggregateType, AggregateId $aggregateId): Snapshot
    {
        $condition = ['aggregate_uuid' => $aggregateId->toString(), 'aggregate_type' => $aggregateType];

        try {
            /** @var SnapshotEntity $entity */
            $entity = SnapshotEntity::query()->where($condition)->firstOrFail();

            /** @var AggregateRoot $aggregateRoot */
            $aggregateRoot = $this->serializer->unserialize($entity->aggregate);
            return new Snapshot($aggregateRoot, $entity->last_version);
        } catch (\Exception $e) {
            /* @var AggregateRoot $aggregateRootClass **/
            $aggregateRootClass = $aggregateType;
            return new Snapshot(new $aggregateRootClass(), 0);
        }
    }
}
