<?php

namespace App\Modules\Warehouse\Infrastructure\Persist;

use App\Modules\Warehouse\DomainModel\Entity\WarehouseEntity;
use App\Modules\Warehouse\DomainModel\Entity\WarehouseItemEntity;
use App\Modules\Warehouse\DomainModel\Entity\WarehouseStateEntity;
use App\Modules\Warehouse\DomainModel\Enum\NameEnum;
use App\Modules\Warehouse\DomainModel\Persist;
use App\Modules\Warehouse\DomainModel\WarehouseState;
use Ramsey\Uuid\Uuid;

class WarehouseStateEloquentRepository implements Persist\WarehouseStateRepository
{
    /**
     * @inheritDoc
     */
    public function find(string $uuid): WarehouseState
    {
        /** @var WarehouseStateEntity $entity */
        $entity = WarehouseStateEntity::query()->where(['uuid' => $uuid])->firstOrFail();

        $warehouseState = new WarehouseState($entity->warehouse->name, $entity->item->ean);
        $warehouseState->setQuantity($entity->quantity);

        return $warehouseState;
    }

    /**
     * @inheritDoc
     */
    public function save(WarehouseState $model): void
    {
        /** @var WarehouseEntity $warehouse */
        $warehouse = WarehouseEntity::query()->where(['name' => $model->warehouseName()])->firstOrFail();
        /** @var WarehouseItemEntity $warehouseItem */
        $warehouseItem = WarehouseItemEntity::query()->where(['ean' => $model->ean()])->firstOrFail();

        $which = ['warehouse_uuid' => $warehouse->uuid, 'item_uuid' => $warehouseItem->uuid];
        WarehouseStateEntity::query()->updateOrInsert($which, [
            'uuid' => Uuid::uuid4()->toString(),
            'quantity' => $model->quantity()
        ]);
    }
}
