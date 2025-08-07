<?php

namespace Tests\Unit;

use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use Tests\TestCase;
use App\Services\StockTransferService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockTransferServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_it_fails_to_transfer_if_stock_is_insufficient(): void
    {
        $item = InventoryItem::factory()->create();
        $fromWarehouse = Warehouse::factory()->create();
        $toWarehouse = Warehouse::factory()->create();

        // Only 3 in stock
        Stock::factory()->create([
            'item_id' => $item->id,
            'warehouse_id' => $fromWarehouse->id,
            'quantity' => 3,
        ]);

        $data = [
            'item_id' => $item->id,
            'from_warehouse_id' => $fromWarehouse->id,
            'to_warehouse_id' => $toWarehouse->id,
            'quantity' => 5,
        ];

        $service = app(StockTransferService::class);
        $response = $service->transfer($data);

        $this->assertEquals($response->status(), 400);
        $this->assertEquals('Insufficient stock', $response->getData()->message);
    }
}
