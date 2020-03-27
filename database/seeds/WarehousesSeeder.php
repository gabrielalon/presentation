<?php

use App\Enum\WarehouseNameEnum;
use App\Warehouse;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class WarehousesSeeder extends Seeder
{
    public function run(): void
    {
        /** @var WarehouseNameEnum $name */
        foreach (WarehouseNameEnum::values() as $name) {
            $data = ['uuid' => Uuid::uuid4()->toString()];
            $where = ['name' => $name->getValue()];
            Warehouse::query()->updateOrCreate($where, $data);
        }
    }
}
