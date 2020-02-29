<?php

namespace App\Modules\Warehouse\Application\Command;

use App\Libraries\Messaging\Command\CommandHandler;
use App\Modules\Warehouse\DomainModel\Persist\WarehouseStateRepository;

abstract class WarehouseStateHandler implements CommandHandler
{
    /** @var WarehouseStateRepository */
    protected $repository;

    /**
     * WarehouseStateHandler constructor.
     * @param WarehouseStateRepository $repository
     */
    public function __construct(WarehouseStateRepository $repository)
    {
        $this->repository = $repository;
    }
}
