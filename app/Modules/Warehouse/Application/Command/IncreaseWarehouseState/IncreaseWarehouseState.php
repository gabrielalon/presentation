<?php

namespace App\Modules\Warehouse\Application\Command\IncreaseWarehouseState;

use App\Libraries\Messaging\Command\Command;

class IncreaseWarehouseState extends Command
{
    /** @var string */
    private $uuid;

    /** @var integer */
    private $changeBy;

    /**
     * IncreaseWarehouseState constructor.
     * @param string $uuid
     * @param int $changeBy
     */
    public function __construct(string $uuid, int $changeBy)
    {
        $this->uuid = $uuid;
        $this->changeBy = $changeBy;
    }

    /**
     * @return string
     */
    public function uuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return int
     */
    public function changeBy(): int
    {
        return $this->changeBy;
    }
}
