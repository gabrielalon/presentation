<?php

namespace App\Modules\Warehouse\Application\Query\ReadModel;

use App\Libraries\Messaging\Query\Viewable;
use Illuminate\Support\Collection;

/**
 * @method WarehouseItemView[] all()
 */
class WarehouseItemsView extends Collection implements Viewable
{}
