<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockTransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_transfer_is_done_successfully_via_API(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = InventoryItem::factory()->create();
        $fromWarehouse = Warehouse::factory()->create();
        $toWarehouse = Warehouse::factory()->create();

        Stock::factory()->create([
            'item_id' => $item->id,
            'warehouse_id' => $fromWarehouse->id,
            'quantity' => 10,
        ]);

        $response = $this->postJson('/api/stock-transfers', [
            'item_id' => $item->id,
            'from_warehouse_id' => $fromWarehouse->id,
            'to_warehouse_id' => $toWarehouse->id,
            'quantity' => 5,
        ]);

        $response->assertStatus(201);
    }
}
