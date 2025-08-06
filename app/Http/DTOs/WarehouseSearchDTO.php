<?php

namespace App\Http\DTOs;

readonly class WarehouseSearchDTO implements DTOContract
{
    public function __construct(
        public ?string $name,
    ) {}
}
