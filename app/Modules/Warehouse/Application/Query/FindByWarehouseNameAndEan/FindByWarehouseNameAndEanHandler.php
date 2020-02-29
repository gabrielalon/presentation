<?php

namespace App\Modules\Warehouse\Application\Query\FindByWarehouseNameAndEan;

use App\Libraries\Messaging\Query\Query;
use App\Libraries\Messaging\Query\Viewable;
use App\Modules\Warehouse\Application\Query\ReadModel\WarehouseStateView;
use App\Modules\Warehouse\Application\Query\WarehouseQueryHandler;

class FindByWarehouseNameAndEanHandler extends WarehouseQueryHandler
{
    /**
     * @param Query|FindByWarehouseNameAndEan $query
     * @return Viewable|WarehouseStateView
     */
    public function run(Query $query): Viewable
    {
        return $this->query->findByWarehouseNameAndEan($query->warehouseName(), $query->ean());
    }
}
