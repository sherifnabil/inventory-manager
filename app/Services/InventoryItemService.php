<?php

namespace App\Services;

use App\Http\DTOs\DTOContract;
use App\Models\InventoryItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class InventoryItemService
{
    public function search(DTOContract $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = InventoryItem::query()
            ->when(
                !empty($filters->name),
                fn($q) => $q->where('name', 'LIKE', '%' . $filters->name . '%')
            )
            ->when(
                !empty($filters->min_price),
                fn($q) => $q->where('price', '>=', $filters->min_price)
            )
            ->when(
                !empty($filters->max_price),
                fn($q) => $q->where('price', '<=', $filters->max_price)
            );

        return $query->paginate($perPage);
    }

    public function create(array $data): InventoryItem
    {
        return InventoryItem::create($data);
    }


    public function update(InventoryItem $item, array $data): InventoryItem
    {
        $item->update($data);
        return $item->refresh();
    }

    public function find(string $id): InventoryItem
    {
        return InventoryItem::findOrFail($id);
    }

    public function delete(InventoryItem $item): void
    {
        $item->delete();
    }
}
