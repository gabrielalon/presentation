<?php

use App\Modules\Warehouse\Application\Ean;
use App\Modules\Warehouse\DomainModel\Enum\NameEnum;
use App\Modules\Warehouse\DomainModel\Entity\WarehouseItemEntity;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class WarehouseItemsSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        foreach (range(1, 50) as $i) {
            $data = ['uuid' => Uuid::uuid4()->toString()];
            $where = ['ean' => $this->uniqueEAN()];
            WarehouseItemEntity::query()->updateOrCreate($where, $data);
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
