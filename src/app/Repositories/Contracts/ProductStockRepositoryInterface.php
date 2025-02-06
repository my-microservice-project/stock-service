<?php

namespace App\Repositories\Contracts;

use App\Data\ProductStockDTO;

interface ProductStockRepositoryInterface
{
    public function getStock(int $productId): int;

    public function update(array $toArray): ProductStockDTO;

    public function sync(array $attributes): ProductStockDTO;

}
