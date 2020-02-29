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
        $model = $this->repository->find($command->uuid());

        $newQuantity = $model->quantity() - $command->changeBy();
        $model->setQuantity(max(0, $newQuantity));

        $this->repository->save($model);
    }
}
