<?php

namespace App\Modules\Warehouse\DomainModel\Persist;

use App\Modules\Warehouse\DomainModel\WarehouseState;

interface WarehouseStateRepository
{
    /**
     * @param string $uuid
     * @return WarehouseState
     */
    public function find(string $uuid): WarehouseState;

    /**
     * @param WarehouseState $model
     */
    public function save(WarehouseState $model): void;
}
