<?php

namespace App\Providers;

use App\Libraries\Messaging\Event\EventStreamRepository;
use App\Libraries\Messaging\Snapshot\SnapshotRepository;
use App\Modules\Message\DomainModel\Service\Serializer;
use App\Modules\Message\Infrastructure\Service\JsonSerializer;
use App\Modules\Message\Integration\EventStreamEloquentRepository;
use App\Modules\Message\Integration\SnapshotEloquentRepository;
use App\Modules\Warehouse\Application\Query\WarehouseQuery;
use App\Modules\Warehouse\DomainModel\Persist\WarehouseStateRepository;
use App\Modules\Warehouse\DomainModel\Projection\WarehouseStateProjection;
use App\Modules\Warehouse\DomainModel\Service\WarehouseStateService;
use App\Modules\Warehouse\Infrastructure\Persist\WarehouseStateAggregateRepository;
use App\Modules\Warehouse\Infrastructure\Projection\WarehouseStateEloquentProjector;
use App\Modules\Warehouse\Infrastructure\Query\WarehouseEloquentQuery;
use App\Modules\Warehouse\Infrastructure\Service\WarehouseStateMessagingService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /** @var string[] */
    public $bindings = [
        WarehouseQuery::class => WarehouseEloquentQuery::class,
        WarehouseStateProjection::class => WarehouseStateEloquentProjector::class,
        WarehouseStateRepository::class => WarehouseStateAggregateRepository::class,
        WarehouseStateService::class => WarehouseStateMessagingService::class,

        Serializer::class => JsonSerializer::class,
        EventStreamRepository::class => EventStreamEloquentRepository::class,
        SnapshotRepository::class => SnapshotEloquentRepository::class
    ];
}
