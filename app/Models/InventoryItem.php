<?php

namespace App\Models;

use App\Models\Concerns\HasSKU;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryItem extends Model
{
    use HasFactory, HasSKU;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sku',
        'price',
    ];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'item_id');
    }
}
