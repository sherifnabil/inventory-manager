<?php

namespace App\Services;

use App\Models\Warehouse;
use App\Http\DTOs\DTOContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class WarehouseService
{
    public function search(DTOContract $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = Warehouse::query()
            ->when(
                !empty($filters->name),
                fn($q) => $q->where('name', 'LIKE', '%' . $filters->name . '%')
            );

        return $query->paginate($perPage);
    }

    public function create(array $data): Warehouse
    {
        return Warehouse::create($data);
    }


    public function update(Warehouse $warehouse, array $data): Warehouse
    {
        $warehouse->update($data);
        return $warehouse->refresh();
    }

    public function delete(Warehouse $warehouse): void
    {
        $warehouse->delete();
    }
}
