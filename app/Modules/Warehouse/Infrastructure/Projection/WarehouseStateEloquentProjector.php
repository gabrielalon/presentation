<?php

namespace App\Modules\Warehouse\Infrastructure\Projection;

use App\Modules\Warehouse\DomainModel\Entity\WarehouseEntity;
use App\Modules\Warehouse\DomainModel\Entity\WarehouseItemEntity;
use App\Modules\Warehouse\DomainModel\Entity\WarehouseStateEntity;
use App\Modules\Warehouse\DomainModel\Event;
use App\Modules\Warehouse\DomainModel\Projection\WarehouseStateProjection;

class WarehouseStateEloquentProjector implements WarehouseStateProjection
{
    /**
     * @inheritDoc
     */
    public function onNewWarehouseStateCreated(Event\NewWarehouseStateCreated $event): void
    {
        /** @var WarehouseEntity $warehouse */
        $warehouse = WarehouseEntity::query()->where(['name' => $event->warehouseName()->getValue()])->firstOrFail();
        /** @var WarehouseItemEntity $warehouseItem */
        $warehouseItem = WarehouseItemEntity::query()->where(['ean' => $event->warehouseStateEan()->toString()])->firstOrFail();

        $which = ['warehouse_uuid' => $warehouse->uuid, 'item_uuid' => $warehouseItem->uuid];
        /** @var WarehouseStateEntity $state */
        $state = WarehouseStateEntity::query()->firstOrNew($which, ['uuid' => $event->aggregateId()]);
        $state->quantity = $event->warehouseStateQuantity()->toInteger();
        $state->save();
    }

    /**
     * @inheritDoc
     */
    public function onExistingWarehouseStateQuantityDecreased(Event\ExistingWarehouseStateQuantityDecreased $event): void
    {
        /** @var WarehouseStateEntity $entity */
        $entity = WarehouseStateEntity::query()->findOrFail($event->aggregateId());
        $entity->quantity = $event->warehouseStateQuantity()->toInteger();
        $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function onExistingWarehouseStateQuantityIncreased(Event\ExistingWarehouseStateQuantityIncreased $event): void
    {
        /** @var WarehouseStateEntity $entity */
        $entity = WarehouseStateEntity::query()->findOrFail($event->aggregateId());
        $entity->quantity = $event->warehouseStateQuantity()->toInteger();
        $entity->save();
    }
}
