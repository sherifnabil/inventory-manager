<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150', 'min:3'],
            'price' => ['required', 'numeric', 'min:1'],
        ];
    }
}
