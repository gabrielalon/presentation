<?php

namespace App\Modules\Warehouse\DomainModel;

class Warehouse
{
    /** @var Enum\NameEnum */
    private $name;

    /**
     * Warehouse constructor.
     * @param Enum\NameEnum $name
     */
    public function __construct(Enum\NameEnum $name)
    {
        $this->name = $name;
    }
}
