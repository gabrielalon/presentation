<?php

use Illuminate\Support\Facades\Route;

Route::get('/warehouse/warehouses', 'WarehouseController@warehouses')->name('warehouse.list');
Route::get('/warehouse/items', 'WarehouseController@items')->name('warehouse.item.list');
Route::get('/warehouse/states/{ean}', 'WarehouseController@states')->name('warehouse.state.list');
Route::post('/warehouse/states/{name}/{ean}', 'WarehouseController@store')->name('warehouse.state.store');
Route::post('/warehouse/states/{name}/{ean}/increase', 'WarehouseController@increase')->name('warehouse.state.increase');
Route::post('/warehouse/states/{name}/{ean}/decrease', 'WarehouseController@decrease')->name('warehouse.state.decrease');
