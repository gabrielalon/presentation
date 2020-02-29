<?php

namespace App\Service;

use App\Enum\WarehouseNameEnum;
use App\Warehouse;
use App\WarehouseItem;
use App\WarehouseState;
use Ramsey\Uuid\Uuid;

class WarehouseStateService
{
    /**
     * @param WarehouseNameEnum $warehouseName
     * @param string $ean
     * @param int $quantity
     * @throws \Exception
     */
    public function increase(WarehouseNameEnum $warehouseName, string $ean, int $quantity): void
    {
        $this->change($warehouseName, $ean, $quantity);
    }

    /**
     * @param WarehouseNameEnum $warehouseName
     * @param string $ean
     * @param int $quantity
     * @throws \Exception
     */
    public function decrease(WarehouseNameEnum $warehouseName, string $ean, int $quantity): void
    {
        $this->change($warehouseName, $ean, (-1) * $quantity);
    }

    /**
     * @param WarehouseNameEnum $warehouseName
     * @param string $ean
     * @param int $quantity
     * @throws \Exception
     */
    public function enter(WarehouseNameEnum $warehouseName, string $ean, int $quantity): void
    {
        $oldQuantity = $this->warehouseState($warehouseName, $ean);

        if ($oldQuantity > $quantity) {
            $diff = $oldQuantity - $quantity;
            $this->decrease($warehouseName, $ean, $diff);
        }

        if ($oldQuantity < $quantity) {
            $diff = $quantity - $oldQuantity;
            $this->increase($warehouseName, $ean, $diff);
        }
    }

    /**
     * @param WarehouseNameEnum $warehouseName
     * @param string $ean
     * @param int $changeBy
     * @throws \Exception
     */
    private function change(WarehouseNameEnum $warehouseName, string $ean, int $changeBy): void
    {
        $warehouseState = $this->retrieveWarehouseState($warehouseName, $ean);
        $warehouseState->quantity += $changeBy;
        $warehouseState->save();
    }

    /**
     * @param WarehouseNameEnum $warehouseName
     * @param string $ean
     * @return WarehouseState
     * @throws \Exception
     */
    private function retrieveWarehouseState(WarehouseNameEnum $warehouseName, string $ean): WarehouseState
    {
        /** @var Warehouse $warehouse */
        $warehouse = Warehouse::query()->where(['name' => $warehouseName->getValue()])->firstOrFail();
        /** @var WarehouseItem $warehouseItem */
        $warehouseItem = WarehouseItem::query()->where(['ean' => $ean])->firstOrFail();

        $which = ['warehouse_uuid' => $warehouse->uuid, 'item_uuid' => $warehouseItem->uuid];

        /** @var WarehouseState $warehouseState */
        $warehouseState = WarehouseState::query()->firstOrNew($which, [
            'uuid' => Uuid::uuid4()->toString(),
            'quantity' => 0
        ]);

        return $warehouseState;
    }

    /**
     * @param string $warehouseName
     * @param string $ean
     * @return int
     * @throws \Exception
     */
    public function warehouseState(string $warehouseName, string $ean): int
    {
        return $this->retrieveWarehouseState(new WarehouseNameEnum($warehouseName), $ean)->quantity;
    }
}
