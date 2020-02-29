<?php

namespace App\Libraries\Messaging\Snapshot;

use App\Libraries\Messaging\Aggregate\AggregateId;

interface SnapshotRepository
{
    /**
     * @param Snapshot $snapshot
     */
    public function save(Snapshot $snapshot): void;

    /**
     * @param string $aggregateType
     * @param AggregateId $aggregateId
     * @return Snapshot
     */
    public function get(string $aggregateType, AggregateId $aggregateId): Snapshot;
}
