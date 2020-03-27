<?php

namespace App\Http\Controllers;

use App\Enum\WarehouseNameEnum;
use App\Request\WarehouseStateRequest;
use App\Service\WarehouseStateService;
use App\Warehouse;
use App\WarehouseItem;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /** @var WarehouseStateService */
    private $warehouseStateService;

    /**
     * WarehouseController constructor.
     * @param WarehouseStateService $warehouseStateService
     */
    public function __construct(WarehouseStateService $warehouseStateService)
    {
        $this->middleware('auth');
        $this->warehouseStateService = $warehouseStateService;
    }

    /**
     * @return Renderable
     */
    public function warehouses(): Renderable
    {
        return view('warehouse.warehouses', [
            'warehouses' => Warehouse::all()
        ]);
    }

    /**
     * @return Renderable
     */
    public function items(): Renderable
    {
        return view('warehouse.items', [
            'items' => WarehouseItem::all()
        ]);
    }

    /**
     * @param string $ean
     * @return Renderable
     */
    public function states(string $ean): Renderable
    {
        return view('warehouse.states', [
            'ean' => $ean,
            'warehouses' => Warehouse::all(),
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
        $this->warehouseStateService->enter(new WarehouseNameEnum($name), $ean, $request->input('quantity'));

        return redirect()->action('WarehouseController@states', ['ean' => $ean])
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
        $this->warehouseStateService->increase(new WarehouseNameEnum($name), $ean, $request->get('quantity'));

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
        $this->warehouseStateService->decrease(new WarehouseNameEnum($name), $ean, $request->get('quantity'));

        return redirect()->route('warehouse.state.list', ['ean' => $ean])
            ->with('success', 'Warehouse state decreased.')
        ;
    }
}
