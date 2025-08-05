<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\InventoryItem;
use App\Models\StockTransfer;

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
            'item_id' => fake()->numberBetween(-10000, 10000),
            'from_warehouse_before_quantity' => fake()->numberBetween(-10000, 10000),
            'to_warehouse_before_quantity' => fake()->numberBetween(-10000, 10000),
            'quantity' => fake()->numberBetween(-10000, 10000),
            'transferred_at' => fake()->dateTime(),
            'item_id_warehouse_from_warehouse_id_to_warehouse_id_id' => InventoryItem::factory(),
        ];
    }
}
