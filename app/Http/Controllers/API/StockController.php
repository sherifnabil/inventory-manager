<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiHelper;
use Illuminate\Http\Response;
use App\Services\StockService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StockRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\StockResource;

class StockController extends Controller
{
    public function __construct(
        protected StockService $service
    ) {}

    public function create(StockRequest $request): JsonResponse
    {
        $stock = $this->service->create($request->validated());

        return ApiHelper::apiResponse(
            data: new StockResource($stock->load('item', 'warehouse')),
            statusCode: Response::HTTP_CREATED
        );
    }
}
