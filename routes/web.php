<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/warehouse/warehouses', 'WarehouseController@warehouses')->name('warehouse.list');
Route::get('/warehouse/items', 'WarehouseController@items')->name('warehouse.item.list');
Route::get('/warehouse/states/{ean}', 'WarehouseController@states')->name('warehouse.state.list');
Route::post('/warehouse/states/{name}/{ean}', 'WarehouseController@store')->name('warehouse.state.store');
