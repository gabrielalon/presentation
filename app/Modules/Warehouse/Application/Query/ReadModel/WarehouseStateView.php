<?php

namespace App\Modules\Warehouse\Application\Query\ReadModel;

use App\Libraries\Messaging\Query\Viewable;
use App\Modules\Warehouse\DomainModel\Enum\NameEnum;

class WarehouseStateView implements Viewable
{
    /** @var string */
    private $uuid;

    /** @var string */
    private $warehouseName;

    /** @var string */
    private $ean;

    /** @var integer */
    private $quantity;

    /**
     * WarehouseStateView constructor.
     * @param string $uuid
     * @param NameEnum $warehouseName
     * @param string $ean
     * @param int $quantity
     */
    public function __construct(string $uuid, NameEnum $warehouseName, string $ean, int $quantity)
    {
        $this->uuid = $uuid;
        $this->warehouseName = $warehouseName->getValue();
        $this->ean = $ean;
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function uuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function warehouseName(): string
    {
        return $this->warehouseName;
    }

    /**
     * @return string
     */
    public function ean(): string
    {
        return $this->ean;
    }

    /**
     * @return int
     */
    public function quantity(): int
    {
        return $this->quantity;
    }
}
