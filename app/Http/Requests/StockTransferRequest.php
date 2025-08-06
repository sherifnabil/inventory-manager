<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockTransferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'from_warehouse_id' => ['required', 'exists:warehouses,id'],
            'to_warehouse_id' => ['required', 'exists:warehouses,id'],
            'item_id' => ['required', 'exists:inventory_items,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
