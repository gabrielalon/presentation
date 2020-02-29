<?php

namespace App\Modules\Warehouse\DomainModel\Projection;

use App\Modules\Warehouse\DomainModel\Event;

interface WarehouseStateProjection
{
    /**
     * @param Event\NewWarehouseStateCreated $event
     */
    public function onNewWarehouseStateCreated(Event\NewWarehouseStateCreated $event): void;

    /**
     * @param Event\ExistingWarehouseStateQuantityDecreased $event
     */
    public function onExistingWarehouseStateQuantityDecreased(Event\ExistingWarehouseStateQuantityDecreased $event): void;

    /**
     * @param Event\ExistingWarehouseStateQuantityIncreased $event
     */
    public function onExistingWarehouseStateQuantityIncreased(Event\ExistingWarehouseStateQuantityIncreased $event): void;
}
