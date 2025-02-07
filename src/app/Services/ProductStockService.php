<?php

namespace App\Services;

use App\Data\{CheckAvailabilityDTO, CheckAvailabilityResultDTO, ProductDTO, ProductStockDTO};
use App\Enums\CacheEnum;
use App\Events\StockUpdatedEvent;
use App\Exceptions\StockNotCreatedException;
use App\Repositories\Contracts\ProductStockRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ProductStockService
{
    public function __construct(protected ProductStockRepositoryInterface $productStockRepository)
    {}

    /**
     * @throws StockNotCreatedException
     * @param ProductStockDTO $dto
     * @return ProductStockDTO
     */
    public function sync(ProductStockDTO $dto): ProductStockDTO
    {
        $stock = $this->updateStock($dto);

        $this->updateCache($dto->product_id, $stock->quantity);
        $this->dispatchStockUpdatedEvent($dto->product_id);

        return $stock;
    }

    /**
     * @throws StockNotCreatedException
     * @param ProductStockDTO $dto
     * @return ProductStockDTO
     */
    private function updateStock(ProductStockDTO $dto): ProductStockDTO
    {
        try {
            return $this->productStockRepository->sync($dto->toArray());
        } catch (Exception $exception) {
            throw new StockNotCreatedException();
        }
    }

    /**
     * @param int $productId
     * @param int $quantity
     */
    private function updateCache(int $productId, int $quantity): void
    {
        $cacheKey = CacheEnum::STOCK->getValue() . $productId;

        Cache::forget($cacheKey);
        Cache::put($cacheKey, $quantity);
    }

    /**
     * @param int $productId
     * @return void
     */
    private function dispatchStockUpdatedEvent(int $productId): void
    {
        event(new StockUpdatedEvent($productId));
    }

    /**
     * @param int $productId
     * @return int
     */
    public function getStock(int $productId): int
    {
        return Cache::remember(
            CacheEnum::STOCK->getValue().$productId,
            CacheEnum::STOCK->getTTL(),
            fn() => $this->productStockRepository->getStock($productId)
        );
    }

    /**
     * @param ProductStockDTO $dto
     * @return ProductStockDTO
     */
    public function update(ProductStockDTO $dto): ProductStockDTO
    {
        return $this->productStockRepository->update($dto->toArray());
    }

    /**
     * @param CheckAvailabilityDTO $dto
     * @return Collection
     * @throws Exception
     */
    public function checkAvailability(CheckAvailabilityDTO $dto): Collection
    {
        return $dto->products->map(fn(ProductStockDTO $product) => $this->createAvailabilityResult($product));
    }

    /**
     * @param ProductStockDTO $product
     * @return CheckAvailabilityResultDTO
     */
    private function createAvailabilityResult(ProductStockDTO $product): CheckAvailabilityResultDTO
    {
        $stock = $this->getStock($product->product_id);

        return new CheckAvailabilityResultDTO(
            product_id: $product->product_id,
            quantity: $product->quantity,
            available: $this->isAvailable($stock, $product->quantity)
        );
    }

    /**
     * @param int $stock
     * @param int $requestedQuantity
     * @return bool
     */
    private function isAvailable(int $stock, int $requestedQuantity): bool
    {
        return $stock > 0 && $stock >= $requestedQuantity;
    }
}
