<?php

namespace App\Modules\Warehouse\Application\Query;

use App\Libraries\Messaging\Query\QueryHandler;

abstract class WarehouseQueryHandler implements QueryHandler
{
    /** @var WarehouseQuery */
    protected $query;

    /**
     * GetByWarehouseNameAndEanHandler constructor.
     * @param WarehouseQuery $query
     */
    public function __construct(WarehouseQuery $query)
    {
        $this->query = $query;
    }
}
