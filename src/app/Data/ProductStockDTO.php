<?php

namespace App\Data;

use OpenApi\Annotations as OA;
use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     schema="ProductStockDTO",
 *     type="object",
 *     title="Product Stock Data Transfer Object",
 *     description="Product Stock information",
 *     @OA\Property(property="product_id", type="integer", example=28, description="Ürünün benzersiz kimliği"),
 *     @OA\Property(property="quantity", type="integer", example=50, description="Ürünün stok adedi")
 * )
 */
final class ProductStockDTO extends Data
{
    public function __construct(
        public int $product_id,
        public int $quantity
    ) {}
}
