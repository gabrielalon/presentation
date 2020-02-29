<?php

namespace App\Modules\Warehouse\DomainModel\Event;

use App\Libraries\Messaging\Aggregate\AggregateChanged;
use App\Libraries\Messaging\Aggregate\AggregateRoot;
use App\Modules\Warehouse\DomainModel\Enum\NameEnum;
use App\Modules\Warehouse\DomainModel\Valuing;
use App\Modules\Warehouse\DomainModel\WarehouseState;

class NewWarehouseStateCreated extends AggregateChanged
{
    /**
     * @return Valuing\Uuid
     */
    public function warehouseStateUuid(): Valuing\Uuid
    {
        return Valuing\Uuid::fromString($this->aggregateId());
    }

    /**
     * @return Valuing\Quantity
     */
    public function warehouseStateQuantity(): Valuing\Quantity
    {
        return Valuing\Quantity::fromInteger($this->payload['quantity']);
    }

    /**
     * @return Valuing\Ean
     */
    public function warehouseStateEan(): Valuing\Ean
    {
        return Valuing\Ean::fromString($this->payload['ean']);
    }

    /**
     * @return NameEnum
     */
    public function warehouseName(): NameEnum
    {
        return new NameEnum($this->payload['warehouse_name']);
    }

    /**
     * @param AggregateRoot|WarehouseState $warehouseState
     */
    public function populate(AggregateRoot $warehouseState): void
    {
        $warehouseState->setUuid($this->warehouseStateUuid());
        $warehouseState->setQuantity($this->warehouseStateQuantity());
        $warehouseState->setEan($this->warehouseStateEan());
        $warehouseState->setWarehouseName($this->warehouseName());
    }
}
