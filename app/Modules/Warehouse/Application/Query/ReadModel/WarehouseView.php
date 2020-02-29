<?php

namespace App\Modules\Warehouse\Application\Query\ReadModel;

use App\Libraries\Messaging\Query\Viewable;

class WarehouseView implements Viewable
{
    /** @var string */
    private $uuid;

    /** @var string */
    private $name;

    /**
     * WarehouseView constructor.
     * @param string $uuid
     * @param string $name
     */
    public function __construct(string $uuid, string $name)
    {
        $this->uuid = $uuid;
        $this->name = $name;
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
    public function name(): string
    {
        return $this->name;
    }
}
