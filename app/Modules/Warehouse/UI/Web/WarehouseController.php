<?php

namespace App\Modules\Warehouse\UI\Web;

use App\Http\Controllers\Controller;
use App\Libraries\Messaging\MessageBus;
use App\Modules\Warehouse\Application\Query\FindAllWarehouse\FindAllWarehouse;
use App\Modules\Warehouse\Application\Query\FindAllWarehouseItem\FindAllWarehouseItem;
use App\Modules\Warehouse\Application\Query\FindByWarehouseNameAndEan\FindByWarehouseNameAndEan;
use App\Modules\Warehouse\Application\Query\ReadModel\WarehouseStateView;
use App\Modules\Warehouse\DomainModel\Enum\NameEnum;
use App\Modules\Warehouse\DomainModel\Service\WarehouseStateService;
use Illuminate\Contracts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WarehouseController extends Controller
{
    /** @var MessageBus */
    private $messageBus;

    /** @var WarehouseStateService */
    private $warehouseStateService;

    /**
     * WarehouseController constructor.
     * @param MessageBus $messageBus
     * @param WarehouseStateService $warehouseStateService
     */
    public function __construct(MessageBus $messageBus, WarehouseStateService $warehouseStateService)
    {
        $this->middleware('auth');

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
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(string $name, string $ean, Request $request): RedirectResponse
    {
        $this->warehouseStateService->enter(new NameEnum($name), $ean, $request->input('quantity'));

        return redirect()->route('warehouse.state.list', ['ean' => $ean])
            ->with('success', 'Warehouse state sored.')
        ;
    }

    /**
     * @param string $name
     * @param string $ean
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function increase(string $name, string $ean, Request $request): RedirectResponse
    {
        /** @var WarehouseStateView $warehouseState */
        $warehouseState = $this->messageBus->query(new FindByWarehouseNameAndEan(new NameEnum($name), $ean));
        $this->warehouseStateService->increase($warehouseState->uuid(), $request->input('quantity'));

        return redirect()->route('warehouse.state.list', ['ean' => $ean])
            ->with('success', 'Warehouse state increased.')
        ;
    }

    /**
     * @param string $name
     * @param string $ean
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function decrease(string $name, string $ean, Request $request): RedirectResponse
    {
        /** @var WarehouseStateView $warehouseState */
        $warehouseState = $this->messageBus->query(new FindByWarehouseNameAndEan(new NameEnum($name), $ean));
        $this->warehouseStateService->decrease($warehouseState->uuid(), $request->input('quantity'));

        return redirect()->route('warehouse.state.list', ['ean' => $ean])
            ->with('success', 'Warehouse state decreased.')
        ;
    }
}
