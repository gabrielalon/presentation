<?php

namespace App\Modules\Warehouse\Application\Query\FindAllWarehouseItem;

use App\Libraries\Messaging\Query\Query;
use App\Libraries\Messaging\Query\Viewable;
use App\Modules\Warehouse\Application\Query\ReadModel\WarehouseItemsView;
use App\Modules\Warehouse\Application\Query\WarehouseQueryHandler;

class FindAllWarehouseItemHandler extends WarehouseQueryHandler
{
    /**
     * @param Query|FindAllWarehouseItem $query
     * @return Viewable|WarehouseItemsView
     */
    public function run(Query $query): Viewable
    {
        return $this->query->findAllWarehouseItem();
    }
}
