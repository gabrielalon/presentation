<?php

namespace App\Modules\Warehouse\DomainModel;

use App\Libraries\Messaging\Aggregate\AggregateRoot;

class WarehouseState extends AggregateRoot
{
    /** @var Enum\NameEnum */
    private $warehouseName;

    /** @var Valuing\Ean */
    private $ean;

    /** @var Valuing\Quantity */
    private $quantity;

    /**
     * @param Valuing\Uuid $uuid
     * @return WarehouseState
     */
    public function setUuid(Valuing\Uuid $uuid): WarehouseState
    {
        $this->setAggregateId($uuid);
        return $this;
    }

    /**
     * @param Enum\NameEnum $warehouseName
     * @return WarehouseState
     */
    public function setWarehouseName(Enum\NameEnum $warehouseName): WarehouseState
    {
        $this->warehouseName = $warehouseName;
        return $this;
    }

    /**
     * @param Valuing\Ean $ean
     * @return WarehouseState
     */
    public function setEan(Valuing\Ean $ean): WarehouseState
    {
        $this->ean = $ean;
        return $this;
    }

    /**
     * @param Valuing\Quantity $quantity
     * @return WarehouseState
     */
    public function setQuantity(Valuing\Quantity $quantity): WarehouseState
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @param string $uuid
     * @param string $warehouseName
     * @param string $ean
     * @param int $quantity
     * @return WarehouseState
     */
    public static function createNew(string $uuid, string $warehouseName, string $ean, int $quantity = 0): WarehouseState
    {
        $warehouseState = new self();

        $warehouseState->recordThat(Event\NewWarehouseStateCreated::occur($uuid, [
            'warehouse_name' => $warehouseName,
            'ean' => $ean,
            'quantity' => $quantity
        ]));

        return $warehouseState;
    }

    /**
     * @param int $quantityDiff
     */
    public function increaseQuantity(int $quantityDiff): void
    {
        $newQuantity = $this->quantity->toInteger() + $quantityDiff;

        $this->recordThat(Event\ExistingWarehouseStateQuantityIncreased::occur($this->aggregateId(), [
            'quantity' => $newQuantity
        ]));
    }

    /**
     * @param int $quantityDiff
     */
    public function decreaseQuantity(int $quantityDiff): void
    {
        $newQuantity = $this->quantity->toInteger() - $quantityDiff;

        $this->recordThat(Event\ExistingWarehouseStateQuantityDecreased::occur($this->aggregateId(), [
            'quantity' => $newQuantity
        ]));
    }
}
