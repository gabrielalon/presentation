<?php

namespace App\Modules\Warehouse\Application\Query\ReadModel;

use App\Libraries\Messaging\Query\Viewable;
use Illuminate\Support\Collection;

/**
 * @method WarehouseStateView[] all()
 */
class WarehouseStatesView extends Collection implements Viewable
{}
