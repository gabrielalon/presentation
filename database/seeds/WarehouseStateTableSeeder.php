<?php

use App\Modules\Warehouse\Application\Command\EnterWarehouseState\EnterWarehouseState;
use App\Modules\Warehouse\Application\Ean;
use App\Modules\Warehouse\DomainModel\Enum\NameEnum;
use App\Modules\Warehouse\DomainModel\Entity\WarehouseEntity;
use App\Modules\Warehouse\DomainModel\Entity\WarehouseItemEntity;
use App\Modules\Warehouse\DomainModel\Service\WarehouseStateService;
use App\Libraries\Messaging\MessageBus;
use Illuminate\Database\Seeder;

class WarehouseStateTableSeeder extends Seeder
{
    /**
     * @param WarehouseStateService $service
     * @param MessageBus $bus
     * @throws Exception
     */
    public function run(WarehouseStateService $service, MessageBus $bus): void
    {
        /** @var NameEnum $name */
        foreach (NameEnum::values() as $name) {
            $warehouse = new WarehouseEntity([
                'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'name' => $name->getValue()
            ]);
            $warehouse->save();
        }

        foreach (range(1, 50) as $i) {

            $item = new WarehouseItemEntity([
                'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'ean' => $this->uniqueEAN()
            ]);
            $item->save();

            /** @var NameEnum $name */
            foreach (NameEnum::values() as $name) {
                $bus->handle(new EnterWarehouseState($name, $item->ean));
                $service->enter($name, $item->ean, random_int(1, 10));
            }
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    public function uniqueEAN(): string
    {
        do {
            $number = random_int(10**3, 10**4);
            $code = '200' . str_pad($number, 9, '0');
            $weight = true;
            $sum = 0;
            // Weight for a digit in the checksum is 3, 1, 3.. starting from the last digit.
            // loop backwards to make the loop length-agnostic. The same basic functionality
            // will work for codes of different lengths.
            for ($i = strlen($code) - 1; $i >= 0; $i--) {
                $sum += (int)$code[$i] * ($weight ? 3 : 1);
                $weight = !$weight;
            }
            $code .= (10 - ($sum % 10)) % 10;

            if (true === Ean\Validator::newInstance()->isValid($code)

                &&

                0 === WarehouseItemEntity::query()->where(['ean' => $code])->count()) {
                return $code;
            }
        }
        while (true);
    }
}
