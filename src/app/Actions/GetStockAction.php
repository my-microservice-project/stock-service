<?php

namespace App\Actions;

use App\Data\ProductStockDTO;
use App\Services\ProductStockService;

class GetStockAction
{
    public function __construct(
        protected ProductStockService $productStockService
    ) {}

    public function execute(int $productId): ProductStockDTO
    {
        $stock = $this->productStockService->getStock($productId);

        return new ProductStockDTO(
            product_id: $productId,
            quantity: $stock
        );
    }

}
