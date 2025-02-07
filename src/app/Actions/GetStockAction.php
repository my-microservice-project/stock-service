<?php

namespace App\Actions;

use App\Data\ProductStockDTO;
use App\Enums\CacheEnum;
use App\Repositories\Contracts\ProductStockRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class GetStockAction
{
    public function __construct(
        protected ProductStockRepositoryInterface $productStockRepository
    ) {}

    public function execute(int $productId): ProductStockDTO
    {
        $stock = Cache::remember(
            CacheEnum::STOCK->getValue().$productId,
            CacheEnum::STOCK->getTTL(),
            fn() => $this->productStockRepository->getStock($productId)
        );

        return new ProductStockDTO(
            product_id: $productId,
            quantity: $stock
        );
    }

}
