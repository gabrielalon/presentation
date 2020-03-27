<?php

use App\Modules\Warehouse\Application\Command\EnterWarehouseState\EnterWarehouseState;
use App\Modules\Warehouse\DomainModel\Enum\NameEnum;
use App\Modules\Warehouse\DomainModel\Entity\WarehouseItemEntity;
use App\Libraries\Messaging\MessageBus;
use Illuminate\Database\Seeder;

class WarehouseStatesSeeder extends Seeder
{
    /**
     * @param MessageBus $bus
     * @throws Exception
     */
    public function run(MessageBus $bus): void
    {
        /** @var WarehouseItemEntity $item */
        foreach (WarehouseItemEntity::all() as $item) {
            /** @var NameEnum $name */
            foreach (NameEnum::values() as $name) {
                $bus->handle(new EnterWarehouseState($name, $item->ean));
            }
        }
    }
}
