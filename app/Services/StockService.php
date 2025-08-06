<?php

namespace App\Services;

use App\Models\Stock;
use App\Models\Warehouse;
use App\Http\DTOs\DTOContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StockService
{
    public function create(array $data): Stock
    {
        return Stock::firstOrCreate(
            [
                'item_id' => $data['item_id'],
                'warehouse_id' => $data['warehouse_id'],
            ],
            ['quantity' => $data['quantity']]
        );
    }
}
