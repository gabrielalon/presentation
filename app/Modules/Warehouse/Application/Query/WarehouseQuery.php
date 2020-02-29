<?php

namespace App\Modules\Warehouse\Application\Query;

interface WarehouseQuery
{
    /**
     * @return ReadModel\WarehousesView
     */
    public function findAllWarehouse(): ReadModel\WarehousesView;

    /**
     * @return ReadModel\WarehouseItemsView
     */
    public function findAllWarehouseItem(): ReadModel\WarehouseItemsView;

    /**
     * @param string $warehouseName
     * @param string $ean
     * @return ReadModel\WarehouseStateView
     */
    public function findByWarehouseNameAndEan(string $warehouseName, string $ean): ReadModel\WarehouseStateView;
}
