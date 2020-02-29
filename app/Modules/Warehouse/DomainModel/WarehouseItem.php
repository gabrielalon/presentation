<?php

namespace App\Modules\Warehouse\DomainModel;

class WarehouseItem
{
    /** @var string */
    private $ean;

    /**
     * WarehouseItem constructor.
     * @param string $ean
     */
    public function __construct(string $ean)
    {
        $this->ean = $ean;
    }
}
