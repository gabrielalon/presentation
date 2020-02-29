<?php

namespace App\Modules\Warehouse\DomainModel\Service;

use App\Modules\Warehouse\DomainModel\Enum\NameEnum as WarehouseNameEnum;

interface WarehouseStateService
{
    /**
     * @param string $uuid
     * @param int $quantity
     */
    public function decrease(string $uuid, int $quantity): void;

    /**
     * @param string $uuid
     * @param int $quantity
     */
    public function increase(string $uuid, int $quantity): void;

    /**
     * @param WarehouseNameEnum $warehouseName
     * @param string $ean
     * @param int $quantity
     */
    public function enter(WarehouseNameEnum $warehouseName, string $ean, int $quantity): void;

    /**
     * @param string $warehouseName
     * @param string $ean
     * @return int
     */
    public function warehouseState(string $warehouseName, string $ean): int;
}
