<?php

use App\Enum\WarehouseNameEnum;
use App\Service\WarehouseStateService;
use App\WarehouseItem;
use Illuminate\Database\Seeder;

class WarehouseStatesSeeder extends Seeder
{
    /**
     * @param WarehouseStateService $service
     * @throws Exception
     */
    public function run(WarehouseStateService $service): void
    {
        /** @var WarehouseItem $item */
        foreach (WarehouseItem::all() as $item) {
            /** @var WarehouseNameEnum $name */
            foreach (WarehouseNameEnum::values() as $name) {
                $service->enter($name, $item->ean, 0);
            }
        }
    }
}
