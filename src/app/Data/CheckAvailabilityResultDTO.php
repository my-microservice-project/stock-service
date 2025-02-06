<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class CheckAvailabilityResultDTO extends Data
{
    public function __construct(
        public int $product_id,
        public int $quantity,
        public bool $available
    ) {}
}
