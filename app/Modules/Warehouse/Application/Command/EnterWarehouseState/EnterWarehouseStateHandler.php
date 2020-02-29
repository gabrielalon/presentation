<?php

namespace App\Modules\Warehouse\Application\Command\EnterWarehouseState;

use App\Libraries\Messaging\Command\Command;
use App\Modules\Warehouse\Application\Command\WarehouseStateHandler;
use App\Modules\Warehouse\DomainModel\Enum\NameEnum;
use App\Modules\Warehouse\DomainModel\WarehouseState;

class EnterWarehouseStateHandler extends WarehouseStateHandler
{
    /**
     * @param Command|EnterWarehouseState $command
     */
    public function run(Command $command): void
    {
        $model = new WarehouseState(
            new NameEnum($command->warehouseName()),
            $command->ean()
        );
        $this->repository->save($model);
    }
}
