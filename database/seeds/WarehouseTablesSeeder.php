<?php

class WarehouseTablesSeeder extends \Illuminate\Database\Seeder
{
    /**
     * @param \App\Service\WarehouseStateService $service
     * @throws Exception
     */
    public function run(\App\Service\WarehouseStateService $service)
    {
        \App\Warehouse::query()->updateOrCreate(['name' => \App\Enum\WarehouseNameEnum::ARVATO()->getValue()], [
            'uuid' => \Ramsey\Uuid\Uuid::uuid4(),
        ]);

        \App\Warehouse::query()->updateOrCreate(['name' => \App\Enum\WarehouseNameEnum::MAIN()->getValue()], [
            'uuid' => \Ramsey\Uuid\Uuid::uuid4(),
        ]);

        \App\Warehouse::query()->updateOrCreate(['name' => \App\Enum\WarehouseNameEnum::SPEDIMEX()->getValue()], [
            'uuid' => \Ramsey\Uuid\Uuid::uuid4(),
        ]);

        \App\Warehouse::query()->updateOrCreate(['name' => \App\Enum\WarehouseNameEnum::CORRECTION()->getValue()], [
            'uuid' => \Ramsey\Uuid\Uuid::uuid4(),
        ]);

        for ($i = 1; $i < 50; $i++) {
            $ean = \App\Ean\Generator::unique();

            \App\WarehouseItem::query()->updateOrInsert(['ean' => $ean], ['uuid' => \Ramsey\Uuid\Uuid::uuid4(),]);

            $service->enter(\App\Enum\WarehouseNameEnum::ARVATO(), $ean, random_int(1, 10));
            $service->enter(\App\Enum\WarehouseNameEnum::MAIN(), $ean, random_int(1, 10));
            $service->enter(\App\Enum\WarehouseNameEnum::SPEDIMEX(), $ean, random_int(1, 10));
            $service->enter(\App\Enum\WarehouseNameEnum::CORRECTION(), $ean, random_int(1, 10));
        }
    }
}
