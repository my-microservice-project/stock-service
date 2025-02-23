<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "CheckAvailabilityResultDTO",
    properties: [
        new OA\Property(property: "product_id", description: "Product ID", type: "integer", example: 101),
        new OA\Property(property: "quantity", description: "Requested quantity", type: "integer", example: 3),
        new OA\Property(property: "available", description: "Availability status", type: "boolean", example: true),
    ],
    type: "object"
)]
class CheckAvailabilityResultDTO extends Data
{
    public function __construct(
        public int $product_id,
        public int $quantity,
        public bool $available
    ) {}
}
