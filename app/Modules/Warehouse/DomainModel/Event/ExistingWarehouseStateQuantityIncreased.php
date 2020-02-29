<?php

namespace App\Modules\Warehouse\DomainModel\Event;

use App\Libraries\Messaging\Aggregate\AggregateChanged;
use App\Libraries\Messaging\Aggregate\AggregateRoot;
use App\Modules\Warehouse\DomainModel\Valuing;
use App\Modules\Warehouse\DomainModel\WarehouseState;

class ExistingWarehouseStateQuantityIncreased extends AggregateChanged
{
    /**
     * @return Valuing\Quantity
     */
    public function warehouseStateQuantity(): Valuing\Quantity
    {
        return Valuing\Quantity::fromInteger($this->payload['quantity']);
    }

    /**
     * @param AggregateRoot|WarehouseState $warehouseState
     */
    public function populate(AggregateRoot $warehouseState): void
    {
        $warehouseState->setQuantity($this->warehouseStateQuantity());
    }
}
