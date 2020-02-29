<?php

use App\Libraries\Messaging\Snapshot\Snapshot;
use App\Libraries\Messaging\Snapshot\SnapshotRepository;
use App\Modules\Warehouse\DomainModel\Entity\WarehouseStateEntity;
use App\Modules\Warehouse\DomainModel\WarehouseState;
use Illuminate\Database\Seeder;

class WarehouseStateTableSeeder extends Seeder
{
    public function run(SnapshotRepository $repository)
    {
        foreach (WarehouseStateEntity::all() as $warehouseState)
        {
            $model = WarehouseState::createNew(
                $warehouseState->uuid,
                $warehouseState->warehouse->name,
                $warehouseState->item->ean,
                $warehouseState->quantity
            );
            $repository->save(new Snapshot($model, $model->version()));
        }
    }
}
