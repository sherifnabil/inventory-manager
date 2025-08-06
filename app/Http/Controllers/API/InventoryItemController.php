<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\InventoryItemService;
use App\Http\DTOs\InventoryItemSearchDTO;
use App\Http\Requests\InventoryItemRequest;
use App\Http\Resources\InventoryItemResource;
use App\Models\InventoryItem;

class InventoryItemController extends Controller
{
    public function __construct(
        protected InventoryItemService $service
    ) {}

    public function index(Request $request): JsonResponse
    {
        $searchDTO = new InventoryItemSearchDTO(
            name: $request->input('name'),
            min_price: (float) $request->input('min_price'),
            max_price: (float) $request->input('max_price'),
            warehouse_id: null
        );

        $items = $this->service->search($searchDTO, $request->input('per_page', 10));

        return ApiHelper::paginationApiResponse(InventoryItemResource::collection($items), $items->items());
    }

    public function store(InventoryItemRequest $request): JsonResponse
    {
        $item = $this->service->create($request->validated());

        return ApiHelper::apiResponse(
            data: new InventoryItemResource($item),
            statusCode: Response::HTTP_CREATED
        );
    }

    public function show(InventoryItem $inventory_item): JsonResponse
    {
        return ApiHelper::apiResponse(new InventoryItemResource($inventory_item));
    }

    public function update(InventoryItemRequest $request, InventoryItem $inventory_item): JsonResponse
    {
        $item = $this->service->update($inventory_item, $request->validated());

        return ApiHelper::apiResponse(new InventoryItemResource($item));
    }

    public function destroy(InventoryItem $inventory_item): JsonResponse
    {
        $this->service->delete($inventory_item);

        return ApiHelper::apiResponse(data: null, statusCode: Response::HTTP_NO_CONTENT);
    }
}
