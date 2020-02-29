<?php

namespace App\Modules\Warehouse\Presentation\UI\Web;

use App\Http\Controllers\Controller;
use App\Libraries\Messaging\Event\EventStorage;
use App\Libraries\Messaging\MessageBus;
use App\Modules\Warehouse\Application\Query\FindAllWarehouse\FindAllWarehouse;
use App\Modules\Warehouse\Application\Query\FindAllWarehouseItem\FindAllWarehouseItem;
use App\Modules\Warehouse\Application\Query\FindByWarehouseNameAndEan\FindByWarehouseNameAndEan;
use App\Modules\Warehouse\Application\Query\ReadModel\WarehouseStateView;
use App\Modules\Warehouse\DomainModel\Enum\NameEnum;
use App\Modules\Warehouse\DomainModel\Service\WarehouseStateService;
use App\Modules\Warehouse\DomainModel\Valuing\Uuid;
use App\Modules\Warehouse\DomainModel\WarehouseState;
use App\Modules\Warehouse\Presentation\UI\Request\WarehouseStateRequest;
use Illuminate\Contracts;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WarehouseController extends Controller
{
    /** @var MessageBus */
    private $messageBus;

    /** @var EventStorage */
    private $eventStorage;

    /** @var WarehouseStateService */
    private $warehouseStateService;

    /**
     * WarehouseController constructor.
     * @param MessageBus $messageBus
     * @param EventStorage $eventStorage
     * @param WarehouseStateService $warehouseStateService
     */
    public function __construct(
        MessageBus $messageBus,
        EventStorage $eventStorage,
        WarehouseStateService $warehouseStateService
    ) {
        $this->middleware('auth');

        $this->messageBus = $messageBus;
        $this->eventStorage = $eventStorage;
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
     */
    public function state(string $name, string $ean): void
    {
        /** @var WarehouseStateView $warehouseState */
        $warehouseState = $this->messageBus->query(new FindByWarehouseNameAndEan(new NameEnum($name), $ean));
        $aggregateId = Uuid::fromString($warehouseState->uuid());

        $warehouseState = WarehouseState::reconstituteFromHistory($this->eventStorage->load($aggregateId, 0));

        dd($warehouseState);
        die;
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
