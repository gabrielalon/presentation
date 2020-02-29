<?php

namespace App\Modules\Warehouse\DomainModel;

class WarehouseState
{
    /** @var Enum\NameEnum */
    private $warehouseName;

    /** @var Valuing\Ean */
    private $ean;

    /** @var Valuing\Quantity */
    private $quantity;

    /**
     * WarehouseState constructor.
     * @param Enum\NameEnum $warehouseName
     * @param string $ean
     * @param integer $quantity
     * @throws \InvalidArgumentException
     */
    public function __construct(Enum\NameEnum $warehouseName, string $ean, int $quantity = 0)
    {
        $this->warehouseName = $warehouseName;
        $this->ean = Valuing\Ean::fromString($ean);
        $this->setQuantity($quantity);
    }

    /**
     * @param integer $quantity
     * @return WarehouseState
     */
    public function setQuantity(int $quantity): WarehouseState
    {
        $this->quantity = Valuing\Quantity::fromInteger($quantity);
        return $this;
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
        return $this->ean->toString();
    }

    /**
     * @return int
     */
    public function quantity(): int
    {
        return $this->quantity->toInteger();
    }
}
