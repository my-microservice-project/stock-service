<?php

namespace App\Jobs;

use App\Data\ProductStockDTO;
use App\Exceptions\StockNotCreatedException;
use App\Services\ProductStockService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SyncStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    private array $productDTO;

    public function __construct(array $data)
    {
        $this->productDTO = $data['productDTO'] ?? [];
    }

    /**
     * @throws StockNotCreatedException
     */
    public function handle(ProductStockService $productStockService): void
    {
        if (!empty($this->productDTO['product_id']) && isset($this->productDTO['stock'])) {
            $dto = new ProductStockDTO(
                product_id: $this->productDTO['product_id'],
                quantity: $this->productDTO['stock']
            );

            $productStockService->sync($dto);
        } else {
            Log::error('Gelen veri hatalı veya eksik: ' . json_encode($this->productDTO));
        }
    }
}

