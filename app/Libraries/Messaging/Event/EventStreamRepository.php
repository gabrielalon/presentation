<?php

namespace App\Libraries\Messaging\Event;

use App\Libraries\Messaging\Aggregate\AggregateChanged;
use App\Libraries\Messaging\Aggregate\AggregateId;

interface EventStreamRepository
{
    /**
     * @param AggregateChanged $event
     */
    public function save(AggregateChanged $event): void;

    /**
     * @param AggregateId $aggregateId
     * @param int $lastVersion
     * @return AggregateChanged[]
     */
    public function load(AggregateId $aggregateId, int $lastVersion): array;
}
