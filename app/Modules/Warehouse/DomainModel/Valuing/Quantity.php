<?php

namespace App\Modules\Warehouse\DomainModel\Valuing;

class Quantity
{
    /** @var int */
    private $quantity;

    /**
     * Quantity constructor.
     * @param int $quantity
     */
    private function __construct(int $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @param int $quantity
     * @return Quantity
     */
    public static function fromInteger(int $quantity): Quantity
    {
        return new self($quantity);
    }

    /**
     * @return int
     */
    public function toInteger(): int
    {
        return $this->quantity;
    }
}
