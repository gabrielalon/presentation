<?php

namespace App\Modules\Warehouse\Application\Query\ReadModel;

use App\Libraries\Messaging\Query\Viewable;
use Illuminate\Support\Collection;

/**
 * @method WarehouseView[] all()
 */
class WarehousesView extends Collection implements Viewable
{}
