<?php

namespace Database\Factories;

use App\Models\InventoryItem;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use App\Models\StockTransfer;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockTransferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StockTransfer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'item_id' => InventoryItem::factory(),
            'from_warehouse_before_quantity' => fake()->numberBetween(-10000, 10000),
            'to_warehouse_before_quantity' => fake()->numberBetween(-10000, 10000),
            'quantity' => fake()->numberBetween(-10000, 10000),
            'transferred_at' => fake()->dateTime(),
            'from_warehouse_id' => Warehouse::factory(),
            'to_warehouse_id' => Warehouse::factory(),
        ];
    }
}
