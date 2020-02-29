<?php

namespace App\Modules\Warehouse\Application\Command\IncreaseWarehouseState;

use App\Libraries\Messaging\Command\Command;
use App\Modules\Warehouse\Application\Command\WarehouseStateHandler;

class IncreaseWarehouseStateHandler extends WarehouseStateHandler
{
    /**
     * @param Command|IncreaseWarehouseState $command
     */
    public function run(Command $command): void
    {
        $warehouseState = $this->repository->find($command->uuid());
        $warehouseState->increaseQuantity($command->changeBy());

        $this->repository->save($warehouseState);
    }
}
