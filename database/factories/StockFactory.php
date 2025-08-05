<?php

namespace Database\Factories;

use App\Models\Stock;
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
            'quantity' => fake()->numberBetween(-10000, 10000),
            'item_id' => InventoryItem::factory(),
        ];
    }
}
