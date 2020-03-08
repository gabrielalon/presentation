<?php

namespace App\Modules\Warehouse\Infrastructure\Service;

use App\Libraries\Messaging\MessageBus;
use App\Modules\Warehouse\Application\Command\DecreaseWarehouseState\DecreaseWarehouseState;
use App\Modules\Warehouse\Application\Command\IncreaseWarehouseState\IncreaseWarehouseState;
use App\Modules\Warehouse\Application\Query\FindByWarehouseNameAndEan\FindByWarehouseNameAndEan;
use App\Modules\Warehouse\Application\Query\ReadModel\WarehouseStateView;
use App\Modules\Warehouse\DomainModel\Enum\NameEnum;
use App\Modules\Warehouse\DomainModel\Enum\NameEnum as WarehouseNameEnum;
use App\Modules\Warehouse\DomainModel\Service\WarehouseStateService;

class WarehouseStateMessagingService implements WarehouseStateService
{
    /** @var MessageBus */
    private $messageBus;

    /**
     * WarehouseStateService constructor.
     * @param MessageBus $messageBus
     */
    public function __construct(MessageBus $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @inheritDoc
     */
    public function decrease(string $uuid, int $quantity): void
    {
        $this->messageBus->handle(new DecreaseWarehouseState($uuid, $quantity));
    }

    /**
     * @inheritDoc
     */
    public function increase(string $uuid, int $quantity): void
    {
        $this->messageBus->handle(new IncreaseWarehouseState($uuid, $quantity));
    }

    /**
     * @inheritDoc
     */
    public function enter(WarehouseNameEnum $warehouseName, string $ean, int $quantity): void
    {
        /** @var WarehouseStateView $warehouseState */
        $warehouseState = $this->messageBus->query(new FindByWarehouseNameAndEan($warehouseName, $ean));

        if ($warehouseState->quantity() > $quantity) {
            $diff = $warehouseState->quantity() - $quantity;
            $this->decrease($warehouseState->uuid(), $diff);
        }

        if ($warehouseState->quantity() < $quantity) {
            $diff = $quantity - $warehouseState->quantity();
            $this->increase($warehouseState->uuid(), $diff);
        }
    }

    /**
     * @inheritDoc
     */
    public function warehouseState(string $warehouseName, string $ean): int
    {
        $warehouseNameEnum = new NameEnum($warehouseName);

        /** @var WarehouseStateView $warehouseState */
        $warehouseState = $this->messageBus->query(new FindByWarehouseNameAndEan($warehouseNameEnum, $ean));

        return $warehouseState->quantity();
    }
}
