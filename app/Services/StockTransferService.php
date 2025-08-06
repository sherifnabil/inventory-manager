<?php

namespace App\Services;

use App\Models\Stock;
use App\Helpers\ApiHelper;
use App\Models\StockTransfer;
use Illuminate\Http\Response;
use App\Http\DTOs\DTOContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\StockTransferResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StockTransferService
{
    /**
     * Stock Transfer Filtering
     * @param \App\Http\DTOs\DTOContract $filters
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function search(DTOContract $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = StockTransfer::query()
            ->when(
                !empty($filters->from_warehouse_id),
                fn($q) => $q->where('from_warehouse_id', $filters->from_warehouse_id)
            )
            ->when(
                !empty($filters->to_warehouse_id),
                fn($q) => $q->where('to_warehouse_id', $filters->to_warehouse_id)
            )
            ->when(
                !empty($filters->item_id),
                fn($q) => $q->where('item_id', $filters->item_id)
            )
            ->when(
                !empty($filters->quantity),
                fn($q) => $q->where('quantity', $filters->quantity)
            );

        return $query->paginate($perPage);
    }

    /**
     * Create a transfer record
     * @param array $data
     * @return StockTransfer
     */
    protected function create(array $data): StockTransfer
    {
        return StockTransfer::create($data);
    }

    /**
     * Transfer stock from one warehouse to another.
     * @param array $data
     * @return JsonResponse
     */
    public function transfer(array $data)
    {
        $stockFrom = Stock::where('item_id', $data['item_id'])
            ->where('warehouse_id', $data['from_warehouse_id'])
            ->first();

        if (!$stockFrom || ($stockFrom->quantity < $data['quantity'])) {
            return ApiHelper::failApiResponse(
                msg: 'Insufficient stock',
                statusCode: Response::HTTP_BAD_REQUEST
            );
        }

        return $this->handleTransfer($stockFrom, $data);
    }

    /**
     * Handle the stock transfer logic with transaction.
     * @param Stock $stockFrom
     * @param array $data
     * @return JsonResponse
     */
    private function handleTransfer(Stock $stockFrom, array $data): JsonResponse
    {
        DB::beginTransaction();
        try {
            // Create stock transfer
            $transfer = $this->create($data);

            // Update stock in the from warehouse
            $stockFrom->decrement('quantity', $data['quantity']);

            // Check if stock exists in the to warehouse
            $stockTo = Stock::firstOrCreate([
                'item_id' => $data['item_id'],
                'warehouse_id' => $data['to_warehouse_id']
            ]);

            // Update stock in the to warehouse
            $stockTo->increment('quantity', $data['quantity']);

            DB::commit();
            return ApiHelper::apiResponse(
                data: new StockTransferResource($transfer->load('item', 'fromWarehouse', 'toWarehouse')),
                statusCode: Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiHelper::failApiResponse(
                msg: 'Transfer failed',
                statusCode: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
