<?php

namespace App\Providers;

use App\Modules\Warehouse\Application\Query\WarehouseQuery;
use App\Modules\Warehouse\DomainModel\Persist\WarehouseStateRepository;
use App\Modules\Warehouse\DomainModel\Service\WarehouseStateService;
use App\Modules\Warehouse\Infrastructure\Persist\WarehouseStateEloquentRepository;
use App\Modules\Warehouse\Infrastructure\Query\WarehouseEloquentQuery;
use App\Modules\Warehouse\Infrastructure\Service\WarehouseStateMessagingService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /** @var string[] */
    public $bindings = [
        WarehouseQuery::class => WarehouseEloquentQuery::class,
        WarehouseStateRepository::class => WarehouseStateEloquentRepository::class,
        WarehouseStateService::class => WarehouseStateMessagingService::class
    ];
}
