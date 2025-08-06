<?php

namespace App\Http\DTOs;

readonly class StockTransferSearchDTO implements DTOContract
{
    public function __construct(
        public ?string $from_warehouse_id,
        public ?string $to_warehouse_id,
        public ?string $item_id,
        public ?int $quantity,
    ) {}
}
