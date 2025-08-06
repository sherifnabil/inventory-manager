<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\InventoryItemController;

/** Inventory Item Routes */
Route::apiResource('inventory-items', InventoryItemController::class);
