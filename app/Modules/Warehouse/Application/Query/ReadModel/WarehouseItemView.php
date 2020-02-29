<?php

namespace App\Modules\Warehouse\Application\Query\ReadModel;

use App\Libraries\Messaging\Query\Viewable;

class WarehouseItemView implements Viewable
{
    /** @var string */
    private $uuid;

    /** @var string */
    private $ean;

    /**
     * WarehouseItemView constructor.
     * @param string $uuid
     * @param string $ean
     */
    public function __construct(string $uuid, string $ean)
    {
        $this->uuid = $uuid;
        $this->ean = $ean;
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
    public function ean(): string
    {
        return $this->ean;
    }
}
