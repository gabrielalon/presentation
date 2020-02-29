<?php

namespace App\Modules\Warehouse\Application\Query\FindAllWarehouse;

use App\Libraries\Messaging\Query\Query;
use App\Libraries\Messaging\Query\Viewable;
use App\Modules\Warehouse\Application\Query\FindAllWarehouseItem\FindAllWarehouseItem;
use App\Modules\Warehouse\Application\Query\ReadModel\WarehousesView;
use App\Modules\Warehouse\Application\Query\WarehouseQueryHandler;

class FindAllWarehouseHandler extends WarehouseQueryHandler
{
    /**
     * @param Query|FindAllWarehouseItem $query
     * @return Viewable|WarehousesView
     */
    public function run(Query $query): Viewable
    {
        return $this->query->findAllWarehouse();
    }
}
