<?php

namespace Database\Seeders;

use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Warehouse;
use App\Models\StockTransfer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@app.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('password'),
        ]);

        Warehouse::factory(50)->create();
        InventoryItem::factory(200)->create();
        Stock::factory(500)->create();
        StockTransfer::factory(1000)->create();
    }
}
