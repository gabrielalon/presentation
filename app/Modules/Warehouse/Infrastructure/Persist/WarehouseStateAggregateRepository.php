<?php

namespace App\Modules\Warehouse\Infrastructure\Persist;

use App\Libraries\Messaging\Aggregate\AggregateRepository;
use App\Modules\Warehouse\DomainModel\Persist;
use App\Modules\Warehouse\DomainModel\Valuing\Uuid;
use App\Modules\Warehouse\DomainModel\WarehouseState;

class WarehouseStateAggregateRepository extends AggregateRepository implements Persist\WarehouseStateRepository
{
    /**
     * @inheritDoc
     */
    public function getAggregateRootClass(): string
    {
        return WarehouseState::class;
    }

    /**
     * @inheritDoc
     */
    public function find(string $uuid): WarehouseState
    {
        /** @var WarehouseState $warehouseState */
        $warehouseState = $this->findAggregateRoot(Uuid::fromString($uuid));

        return $warehouseState;
    }

    /**
     * @inheritDoc
     */
    public function save(WarehouseState $model): void
    {
        $this->saveAggregateRoot($model);
    }
}
