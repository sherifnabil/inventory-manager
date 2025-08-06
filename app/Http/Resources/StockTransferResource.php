<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockTransferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'from_warehouse' => new WarehouseResource($this->whenLoaded('fromWarehouse')),
            'to_warehouse' => new WarehouseResource($this->whenLoaded('toWarehouse')),
            'item' => new InventoryItemResource($this->whenLoaded('item')),
            'quantity' => $this->quantity,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
