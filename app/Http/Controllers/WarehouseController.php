<?php

namespace App\Http\Controllers;

use App\Enum\WarehouseNameEnum;
use App\Service\WarehouseStateService;
use App\Warehouse;
use App\WarehouseItem;
use Illuminate\Contracts;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
     * @return Contracts\View\Factory|View
     */
    public function warehouses()
    {
        return view('warehouse.warehouses', [
            'warehouses' => Warehouse::all()
        ]);
    }

    /**
     * @return Contracts\View\Factory|View
     */
    public function items()
    {
        return view('warehouse.items', [
            'items' => WarehouseItem::all()
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
            'warehouses' => Warehouse::all(),
            'warehouseStateService' => $this->warehouseStateService
        ]);
    }

    /**
     * @param string $name
     * @param string $ean
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(string $name, string $ean, Request $request)
    {
        $this->warehouseStateService->enter(new WarehouseNameEnum($name), $ean, $request->input('quantity'));

        return redirect()->action('WarehouseController@states', ['ean' => $ean])
            ->with('success', 'Warehouse state sored.')
            ;
    }
}
