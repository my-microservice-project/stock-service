<?php

namespace App\Data;

use OpenApi\Attributes as OA;
use Spatie\LaravelData\Data;

#[OA\Schema(
    schema: "ProductStockDTO",
    title: "Product Stock Data Transfer Object",
    description: "Product stock information",
    properties: [
        new OA\Property(property: "product_id", description: "Unique identifier of the product", type: "integer", example: 28),
        new OA\Property(property: "quantity", description: "Stock quantity of the product", type: "integer", example: 50),
    ],
    type: "object"
)]
final class ProductStockDTO extends Data
{
    public function __construct(
        public int $product_id,
        public int $quantity
    ) {}
}
