<?php

namespace App\Modules\Warehouse\Infrastructure\Query;

use App\Modules\Warehouse\Application\Query\ReadModel\WarehouseItemsView;
use App\Modules\Warehouse\Application\Query\ReadModel\WarehouseItemView;
use App\Modules\Warehouse\Application\Query\ReadModel\WarehouseStateView;
use App\Modules\Warehouse\Application\Query\ReadModel\WarehousesView;
use App\Modules\Warehouse\Application\Query\ReadModel\WarehouseView;
use App\Modules\Warehouse\Application\Query\WarehouseQuery;
use App\Modules\Warehouse\DomainModel\Entity\WarehouseEntity;
use App\Modules\Warehouse\DomainModel\Entity\WarehouseItemEntity;
use App\Modules\Warehouse\DomainModel\Entity\WarehouseStateEntity;
use App\Modules\Warehouse\DomainModel\Enum\NameEnum;

class WarehouseEloquentQuery implements WarehouseQuery
{
    /**
     * @inheritDoc
     */
    public function findAllWarehouse(): WarehousesView
    {
        $collection = new WarehousesView();

        /** @var WarehouseEntity $entity */
        foreach (WarehouseEntity::all() as $entity) {
            $collection->add(new WarehouseView($entity->uuid, $entity->name));
        }

        return $collection;
    }

    /**
     * @inheritDoc
     */
    public function findAllWarehouseItem(): WarehouseItemsView
    {
        $collection = new WarehouseItemsView();

        /** @var WarehouseItemEntity $entity */
        foreach (WarehouseItemEntity::all() as $entity) {
            $collection->add(new WarehouseItemView($entity->uuid, $entity->ean));
        }

        return $collection;
    }

    /**
     * @inheritDoc
     */
    public function findByWarehouseNameAndEan(string $warehouseName, string $ean): WarehouseStateView
    {
        /** @var WarehouseEntity $warehouse */
        $warehouse = WarehouseEntity::query()->where(['name' => $warehouseName])->firstOrFail();
        /** @var WarehouseItemEntity $warehouseItem */
        $warehouseItem = WarehouseItemEntity::query()->where(['ean' => $ean])->firstOrFail();

        $which = ['warehouse_uuid' => $warehouse->uuid, 'item_uuid' => $warehouseItem->uuid];

        /** @var WarehouseStateEntity $warehouseState */
        $warehouseState = WarehouseStateEntity::query()->where($which)->firstOrFail();

        return new WarehouseStateView($warehouseState->uuid, new NameEnum($warehouseName), $ean, $warehouseState->quantity);
    }
}
