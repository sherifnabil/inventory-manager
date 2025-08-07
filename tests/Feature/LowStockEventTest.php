<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use App\Events\LowStockDetected;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LowStockEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_transfer_is_done_successfully_via_API(): void
    {
        Event::fake();

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
            'quantity' => 6,
        ]);

        Event::assertDispatched(LowStockDetected::class, function ($event) use ($item) {
            return ($event->item->id == $item->id) && ($event->quantity == 4);
        });
    }
}
