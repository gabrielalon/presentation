<?php

use App\Modules\Warehouse;

return [
    Warehouse\DomainModel\Event\NewWarehouseStateCreated::class => [Warehouse\DomainModel\Projection\WarehouseStateProjection::class],
    Warehouse\DomainModel\Event\ExistingWarehouseStateQuantityIncreased::class => [Warehouse\DomainModel\Projection\WarehouseStateProjection::class],
    Warehouse\DomainModel\Event\ExistingWarehouseStateQuantityDecreased::class => [Warehouse\DomainModel\Projection\WarehouseStateProjection::class]
];
