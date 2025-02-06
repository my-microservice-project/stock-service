<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="StockResource",
 *     title="Stock Resource",
 *     description="Product stock information",
 *     @OA\Property(property="product_id", type="integer", example=1, description="Product ID"),
 *     @OA\Property(property="quantity", type="integer", example=50, description="Stock piece"),
 *     @OA\Property(property="available", type="boolean", example=true, description="The product's stock is available")
 * )
 */
class StockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge([
            'product_id' => $this->resource->product_id,
            'quantity' => $this->resource->quantity,
        ], isset($this->resource->available) ? ['available' => $this->resource->available] : []);
    }
}
