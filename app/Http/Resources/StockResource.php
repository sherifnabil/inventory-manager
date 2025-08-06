<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'item_id' => $this->item_id,
            'warehouse_id' => $this->warehouse_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),

            'item' => new InventoryItemResource($this->whenLoaded('item')),
            'warehouse' => new WarehouseResource($this->whenLoaded('warehouse')),
        ];
    }
}
