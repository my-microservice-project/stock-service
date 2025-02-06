<?php

namespace App\Repositories;

use App\Data\ProductStockDTO;
use App\Exceptions\StockNotFoundException;
use App\Models\Stock;
use App\Repositories\Contracts\ProductStockRepositoryInterface;

class ProductStockRepository implements ProductStockRepositoryInterface
{
    public function __construct(protected Stock $model)
    {}

    /**
     * @throws StockNotFoundException
     * @param int $productId
     * @return int
     */
    public function getStock(int $productId): int
    {
        $stock = $this->model->where('product_id', $productId)->first();

        if (!$stock) {
            throw new StockNotFoundException($productId);
        }

        return $stock->quantity;
    }

    /**
     * @param array $toArray
     * @return ProductStockDTO
     */
    public function update(array $toArray): ProductStockDTO
    {
        $stock = $this->model->where('product_id', $toArray['product_id'])->first();

        $stock->update($toArray);

        return ProductStockDTO::from($stock);
    }


    /**
     * @param array $attributes
     * @return ProductStockDTO
     */
    public function sync(array $attributes): ProductStockDTO
    {
        $stock = $this->model->where('product_id', $attributes['product_id'])->first();

        if (!$stock) {
            return $this->create($attributes);
        }

        $stock->update($attributes);

        return ProductStockDTO::from($stock);
    }


    /**
     * @param array $attributes
     * @return ProductStockDTO
     */
    public function create(array $attributes): ProductStockDTO
    {
        return ProductStockDTO::from($this->model->create($attributes));
    }

}
