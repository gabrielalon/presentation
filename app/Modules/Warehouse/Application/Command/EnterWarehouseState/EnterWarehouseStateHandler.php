<?php

namespace App\Modules\Warehouse\Application\Command\EnterWarehouseState;

use App\Libraries\Messaging\Command\Command;
use App\Modules\Warehouse\Application\Command\WarehouseStateHandler;
use App\Modules\Warehouse\DomainModel\WarehouseState;
use Ramsey\Uuid\Uuid;

class EnterWarehouseStateHandler extends WarehouseStateHandler
{
    /**
     * @param Command|EnterWarehouseState $command
     */
    public function run(Command $command): void
    {
        $this->repository->save(WarehouseState::createNew(
            Uuid::uuid4(),
            $command->warehouseName(),
            $command->ean()
        ));
    }
}
