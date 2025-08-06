<?php

namespace Database\Factories;

use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stock::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quantity' => fake()->numberBetween(1, 10000),
            'item_id' => InventoryItem::inRandomOrder()->first()->id ?? InventoryItem::factory()->create()->id,
            'warehouse_id' => Warehouse::inRandomOrder()->first()->id ?? Warehouse::factory()->create()->id,
        ];
    }
}
