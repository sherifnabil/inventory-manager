<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->integer('from_warehouse_before_quantity');
            $table->integer('to_warehouse_before_quantity');
            $table->integer('quantity');
            $table->timestamp('transferred_at')->default('now');
            $table->foreignId('item_id_warehouse_from_warehouse_id_to_warehouse_id_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transfers');
    }
};
