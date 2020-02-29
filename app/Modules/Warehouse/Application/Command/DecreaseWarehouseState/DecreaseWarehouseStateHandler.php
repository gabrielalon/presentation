<?php

namespace App\Modules\Warehouse\Application\Command\DecreaseWarehouseState;

use App\Libraries\Messaging\Command\Command;
use App\Modules\Warehouse\Application\Command\WarehouseStateHandler;

class DecreaseWarehouseStateHandler extends WarehouseStateHandler
{
    /**
     * @param Command|DecreaseWarehouseState $command
     */
    public function run(Command $command): void
    {
        $warehouseState = $this->repository->find($command->uuid());
        $warehouseState->decreaseQuantity($command->changeBy());

        $this->repository->save($warehouseState);
    }
}
