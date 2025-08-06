<?php

namespace App\Services;

use App\Models\InventoryItem;
use App\Http\DTOs\DTOContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class InventoryItemService
{
    public function search(DTOContract $filters, int|string $perPage = 10): LengthAwarePaginator|Collection
    {
        $query = InventoryItem::query()
            ->when(
                !empty($filters->warehouse_id),
                fn($q) => $q->whereHas('stocks', fn($q) => $q->where('warehouse_id', $filters->warehouse_id))
            )
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

        if ($perPage == 'all') {
            $perPage = $query->count();
        }

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

    public function delete(InventoryItem $item): void
    {
        $item->delete();
    }
}
