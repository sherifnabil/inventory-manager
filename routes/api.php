<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StockController;
use App\Http\Controllers\API\WarehouseController;
use App\Http\Controllers\API\InventoryItemController;
use App\Http\Controllers\API\StockTransferController;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')
    ->group(function () {
        // Logout Route
        Route::post('logout', [AuthController::class, 'logout']);

        /**
         *  Inventory Item Routes
         * the requested in task description is route for paginated inventory items
         */
        Route::apiResource('inventory-items', InventoryItemController::class);

        /** Warehouse Routes */
        Route::apiResource('warehouses', WarehouseController::class);


        Route::get('warehouses/{warehouse}/inventory', [WarehouseController::class, 'inventoryItems']);

        /** Adding Warehouse Stock Route */
        Route::post('stocks', [StockController::class, 'create']);

        /** Stock Transfer Routes */
        Route::group(['prefix' => 'stock-transfers'], function () {
            Route::get('/', [StockTransferController::class, 'index']);
            Route::get('/{stockTransfer}', [StockTransferController::class, 'show']);

            /** Task Description route */
            Route::post('/', [StockTransferController::class, 'transfer']);
        });
    });
