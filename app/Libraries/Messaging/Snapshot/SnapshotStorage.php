<?php

namespace App\Libraries\Messaging\Snapshot;

use App\Libraries\Messaging\Aggregate\AggregateId;
use App\Libraries\Messaging\Aggregate\AggregateRoot;

class SnapshotStorage
{
    /** @var SnapshotRepository */
    private $repository;

    /**
     * SnapshotStorage constructor.
     * @param SnapshotRepository $repository
     */
    public function __construct(SnapshotRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param AggregateRoot $aggregateRoot
     */
    public function make(AggregateRoot $aggregateRoot): void
    {
        $this->repository->save(new Snapshot($aggregateRoot, $aggregateRoot->version()));
    }

    /**
     * @param string $aggregateType
     * @param AggregateId $aggregateId
     * @return Snapshot
     */
    public function get(string $aggregateType, AggregateId $aggregateId): Snapshot
    {
        return $this->repository->get($aggregateType, $aggregateId);
    }
}
