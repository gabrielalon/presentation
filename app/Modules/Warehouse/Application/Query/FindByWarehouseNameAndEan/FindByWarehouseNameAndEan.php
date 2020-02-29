<?php

namespace App\Modules\Warehouse\Application\Query\FindByWarehouseNameAndEan;

use App\Modules\Warehouse\DomainModel\Enum\NameEnum as WarehouseNameEnum;
use App\Libraries\Messaging\Query\Query;

class FindByWarehouseNameAndEan extends Query
{
    /** @var WarehouseNameEnum */
    private $warehouseName;

    /** @var string */
    private $ean;

    /**
     * FindByWarehouseNameAndEan constructor.
     * @param WarehouseNameEnum $warehouseName
     * @param string $ean
     */
    public function __construct(WarehouseNameEnum $warehouseName, string $ean)
    {
        $this->warehouseName = $warehouseName;
        $this->ean = $ean;
    }

    /**
     * @return string
     */
    public function warehouseName(): string
    {
        return $this->warehouseName->getValue();
    }

    /**
     * @return string
     */
    public function ean(): string
    {
        return $this->ean;
    }
}
