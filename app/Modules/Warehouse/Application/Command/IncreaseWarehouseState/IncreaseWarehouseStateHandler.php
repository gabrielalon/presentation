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
        $model = $this->repository->find($command->uuid());

        $newQuantity = $model->quantity() + $command->changeBy();
        $model->setQuantity($newQuantity);

        $this->repository->save($model);
    }
}
