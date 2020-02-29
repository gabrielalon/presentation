<?php

namespace App\Modules\Warehouse\Application\Command\EnterWarehouseState;

use App\Libraries\Messaging\Command\Command;
use App\Modules\Warehouse\DomainModel\Enum\NameEnum as WarehouseNameEnum;

class EnterWarehouseState extends Command
{
    /** @var WarehouseNameEnum */
    private $warehouseName;

    /** @var string */
    private $ean;

    /**
     * EnterWarehouseState constructor.
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
