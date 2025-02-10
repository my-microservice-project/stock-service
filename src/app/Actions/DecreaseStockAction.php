<?php

namespace App\Actions;

use App\Data\ProductStockDTO;
use App\Exceptions\StockNotCreatedException;
use App\Services\ProductStockService;

class DecreaseStockAction
{
    public function __construct(
        protected ProductStockService $productStockService
    ) {}


    public function execute(ProductStockDTO $dto): ProductStockDTO
    {
        $product = $this->productStockService->decrease($dto);

        return ProductStockDTO::from($product);
    }

}
