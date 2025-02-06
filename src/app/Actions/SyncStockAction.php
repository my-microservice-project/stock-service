<?php

namespace App\Actions;

use App\Data\ProductStockDTO;
use App\Exceptions\StockNotCreatedException;
use App\Services\ProductStockService;

class SyncStockAction
{
    public function __construct(
        protected ProductStockService $productStockService
    ) {}

    /**
     * @throws StockNotCreatedException
     */
    public function execute(ProductStockDTO $dto): ProductStockDTO
    {
        $product = $this->productStockService->sync($dto);

        return ProductStockDTO::from($product);
    }

}
