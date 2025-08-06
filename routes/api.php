<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StockController;
use App\Http\Controllers\API\WarehouseController;
use App\Http\Controllers\API\InventoryItemController;

/** Inventory Item Routes */
Route::apiResource('inventory-items', InventoryItemController::class);

/** Warehouse Routes */
Route::apiResource('warehouses', WarehouseController::class);

/** Adding Warehouse Stock Route */
Route::post('stocks', [StockController::class, 'create']);
