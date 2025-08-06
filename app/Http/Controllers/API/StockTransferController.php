<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Models\StockTransfer;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\DTOs\StockTransferSearchDTO;
use App\Services\StockTransferService;
use App\Http\Requests\StockTransferRequest;
use App\Http\Resources\StockTransferResource;

class StockTransferController extends Controller
{

    public function __construct(
        protected StockTransferService $service
    ) {}

    /**
     * Filter stock transfers From & To warehouses and items.
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $searchDTO = new StockTransferSearchDTO(
            from_warehouse_id: $request->input('from_warehouse_id'),
            to_warehouse_id: $request->input('to_warehouse_id'),
            item_id: $request->input('item_id'),
            quantity: $request->input('quantity')
        );

        $items = $this->service->search($searchDTO, $request->input('per_page', 10));

        return ApiHelper::paginationApiResponse(StockTransferResource::collection($items), $items->items());
    }

    /**
     * Transfer stock from one warehouse to another.
     * @param \App\Http\Requests\StockTransferRequest $request
     * @return JsonResponse
     */
    public function transfer(StockTransferRequest $request): JsonResponse
    {
        return $this->service->transfer($request->validated());
    }

    /**
     * Show a specific stock transfer.
     * @param \App\Models\StockTransfer $stockTransfer
     * @return JsonResponse
     */
    public function show(StockTransfer $stockTransfer): JsonResponse
    {
        return ApiHelper::apiResponse(new StockTransferResource($stockTransfer->load('item', 'fromWarehouse', 'toWarehouse')));
    }
}
