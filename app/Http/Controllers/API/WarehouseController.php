<?php

namespace App\Http\Controllers\API;

use App\Models\Warehouse;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\WarehouseService;
use App\Http\Controllers\Controller;
use App\Http\DTOs\WarehouseSearchDTO;
use Illuminate\Support\Facades\Cache;
use App\Services\InventoryItemService;
use App\Http\Requests\WarehouseRequest;
use App\Http\DTOs\InventoryItemSearchDTO;
use App\Http\Resources\WarehouseResource;
use App\Http\Resources\InventoryItemResource;

class WarehouseController extends Controller
{
    public function __construct(
        protected WarehouseService $service,
        protected InventoryItemService $inventoryItemService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $searchDTO = new WarehouseSearchDTO(
            name: $request->input('name')
        );

        $items = $this->service->search($searchDTO, $request->input('per_page', 10));

        return ApiHelper::paginationApiResponse(WarehouseResource::collection($items), $items->items());
    }

    public function store(WarehouseRequest $request): JsonResponse
    {
        $item = $this->service->create($request->validated());

        return ApiHelper::apiResponse(
            data: new WarehouseResource($item),
            statusCode: Response::HTTP_CREATED
        );
    }

    public function show(Warehouse $warehouse): JsonResponse
    {
        return ApiHelper::apiResponse(new WarehouseResource($warehouse));
    }

    public function update(WarehouseRequest $request, Warehouse $warehouse): JsonResponse
    {
        $item = $this->service->update($warehouse, $request->validated());

        return ApiHelper::apiResponse(new WarehouseResource($item));
    }

    public function destroy(Warehouse $warehouse): JsonResponse
    {
        $this->service->delete($warehouse);

        return ApiHelper::apiResponse(data: null, statusCode: Response::HTTP_NO_CONTENT);
    }

    public function inventoryItems(Warehouse $warehouse): JsonResponse
    {
        $cacheLifetime = 60 * 60; // 1 hour
        $cacheIdentifier = "warehouse:{$warehouse->id}:inventory";

        $items = match (Cache::has($cacheIdentifier)) {
            true => Cache::get($cacheIdentifier),

            false => Cache::remember(
                $cacheIdentifier,
                $cacheLifetime,
                function () use ($warehouse) {
                    $searchDTO = new InventoryItemSearchDTO(
                        name: null,
                        min_price: null,
                        max_price: null,
                        warehouse_id: $warehouse->id
                    );

                    return $this->inventoryItemService->search(
                        filters: $searchDTO,
                        perPage: 'all'
                    );
                }
            ),
        };

        return ApiHelper::paginationApiResponse(InventoryItemResource::collection($items), $items->items());
    }
}
