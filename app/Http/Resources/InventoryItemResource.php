<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'price' => $this->price,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'stocks' => StockResource::collection($this->whenLoaded('stocks')),
        ];
    }
}
