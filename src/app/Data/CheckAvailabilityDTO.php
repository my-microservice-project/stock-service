<?php

namespace App\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class CheckAvailabilityDTO extends Data
{
    /**
     * @param Collection<int, ProductStockDTO> $products
     */
    public function __construct(
        public Collection $products
    ) {}
}
