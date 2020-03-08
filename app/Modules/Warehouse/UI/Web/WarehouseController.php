<?php

namespace App\Modules\Warehouse\UI\Web;

use App\Http\Controllers\Controller;
use App\Libraries\Messaging\Event\EventStorage;
use App\Libraries\Messaging\MessageBus;
use App\Modules\Message\DomainModel\Entity\EventStreamEntity;
use App\Modules\Message\DomainModel\Service\Serializer;
use App\Modules\Warehouse\Application\Query\FindAllWarehouse\FindAllWarehouse;
use App\Modules\Warehouse\Application\Query\FindAllWarehouseItem\FindAllWarehouseItem;
use App\Modules\Warehouse\Application\Query\FindByWarehouseNameAndEan\FindByWarehouseNameAndEan;
use App\Modules\Warehouse\Application\Query\ReadModel\WarehouseStateView;
use App\Modules\Warehouse\DomainModel\Enum\NameEnum;
use App\Modules\Warehouse\DomainModel\Service\WarehouseStateService;
use App\Modules\Warehouse\UI\Request\WarehouseStateRequest;
use Illuminate\Contracts;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WarehouseController extends Controller
{
    /** @var Serializer */
    private $serializer;

    /** @var MessageBus */
    private $messageBus;

    /** @var WarehouseStateService */
    private $warehouseStateService;

    /**
     * WarehouseController constructor.
     * @param Serializer $serializer
     * @param MessageBus $messageBus
     * @param WarehouseStateService $warehouseStateService
     */
    public function __construct(Serializer $serializer, MessageBus $messageBus, WarehouseStateService $warehouseStateService)
    {
        $this->middleware('auth');

        $this->serializer = $serializer;
        $this->messageBus = $messageBus;
        $this->warehouseStateService = $warehouseStateService;
    }

    /**
     * @return Contracts\View\Factory|View
     */
    public function warehouses()
    {
        return view('warehouse.warehouses', [
            'warehouses' => $this->messageBus->query(new FindAllWarehouse())
        ]);
    }

    /**
     * @return Contracts\View\Factory|View
     */
    public function items()
    {
        return view('warehouse.items', [
            'items' => $this->messageBus->query(new FindAllWarehouseItem())
        ]);
    }

    /**
     * @param string $ean
     * @return Contracts\View\Factory|View
     */
    public function states(string $ean)
    {
        return view('warehouse.states', [
            'ean' => $ean,
            'warehouses' => $this->messageBus->query(new FindAllWarehouse()),
            'warehouseStateService' => $this->warehouseStateService
        ]);
    }

    /**
     * @param string $name
     * @param string $ean
     * @return Contracts\View\Factory|View
     */
    public function state(string $name, string $ean)
    {
        /** @var WarehouseStateView $warehouseState */
        $warehouseState = $this->messageBus->query(new FindByWarehouseNameAndEan(new NameEnum($name), $ean));

        $collection = EventStreamEntity::query()
            ->where(['event_uuid' => $warehouseState->uuid()])
            ->where('version', '>=', 0)
            ->get();

        return view('warehouse.events', [
            'warehouseState' => $warehouseState,
            'serializer' => $this->serializer,
            'events' => $collection
        ]);
    }

    /**
     * @param string $name
     * @param string $ean
     * @param WarehouseStateRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(string $name, string $ean, WarehouseStateRequest $request): RedirectResponse
    {
        $this->warehouseStateService->enter(new NameEnum($name), $ean, $request->get('quantity'));

        return redirect()->route('warehouse.state.list', ['ean' => $ean])
            ->with('success', 'Warehouse state sored.')
            ;
    }

    /**
     * @param string $name
     * @param string $ean
     * @param WarehouseStateRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function increase(string $name, string $ean, WarehouseStateRequest $request): RedirectResponse
    {
        /** @var WarehouseStateView $warehouseState */
        $warehouseState = $this->messageBus->query(new FindByWarehouseNameAndEan(new NameEnum($name), $ean));
        $this->warehouseStateService->increase($warehouseState->uuid(), $request->get('quantity'));

        return redirect()->route('warehouse.state.list', ['ean' => $ean])
            ->with('success', 'Warehouse state increased.')
        ;
    }

    /**
     * @param string $name
     * @param string $ean
     * @param WarehouseStateRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function decrease(string $name, string $ean, WarehouseStateRequest $request): RedirectResponse
    {
        /** @var WarehouseStateView $warehouseState */
        $warehouseState = $this->messageBus->query(new FindByWarehouseNameAndEan(new NameEnum($name), $ean));
        $this->warehouseStateService->decrease($warehouseState->uuid(), $request->get('quantity'));

        return redirect()->route('warehouse.state.list', ['ean' => $ean])
            ->with('success', 'Warehouse state decreased.')
        ;
    }
}
