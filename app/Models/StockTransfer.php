<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockTransfer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'from_warehouse_before_quantity',
        'to_warehouse_before_quantity',
        'quantity',
        'transferred_at',
        'item_id_warehouse_from_warehouse_id_to_warehouse_id_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'transferred_at' => 'timestamp',
            'item_id_warehouse_from_warehouse_id_to_warehouse_id_id' => 'integer',
        ];
    }

    public function itemIdWarehouseFromWarehouseIdToWarehouse(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }
}
