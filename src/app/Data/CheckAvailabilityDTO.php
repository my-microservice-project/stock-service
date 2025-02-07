<?php

namespace App\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "CheckAvailabilityDTO",
    properties: [
        new OA\Property(
            property: "products",
            description: "List of product stock information",
            type: "array",
            items: new OA\Items(ref: "#/components/schemas/ProductStockDTO")
        ),
    ],
    type: "object"
)]
class CheckAvailabilityDTO extends Data
{
    /**
     * @param Collection<int, ProductStockDTO> $products
     */
    public function __construct(
        #[DataCollectionOf(ProductStockDTO::class)]
        public Collection $products
    ) {}
}
