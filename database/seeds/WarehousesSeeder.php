<?php

use App\Modules\Warehouse\DomainModel\Enum\NameEnum;
use App\Modules\Warehouse\DomainModel\Entity\WarehouseEntity;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class WarehousesSeeder extends Seeder
{
    public function run(): void
    {
        /** @var NameEnum $name */
        foreach (NameEnum::values() as $name) {
            $data = ['uuid' => Uuid::uuid4()->toString()];
            $where = ['name' => $name->getValue()];
            WarehouseEntity::query()->updateOrCreate($where, $data);
        }
    }
}
