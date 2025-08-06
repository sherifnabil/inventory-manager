<?php

namespace App\Http\DTOs;

readonly class InventoryItemSearchDTO implements DTOContract
{
    public function __construct(
        public ?string $name,
        public ?float $min_price,
        public ?float $max_price,
        public ?string $warehouse_id
    ) {}
}
