<?php

namespace App\Jobs;

use App\Actions\SyncStockAction;
use App\Data\ProductStockDTO;
use App\Exceptions\StockNotCreatedException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

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
    public function handle(SyncStockAction $action): void
    {
        if (!empty($this->productDTO['product_id']) && isset($this->productDTO['stock'])) {
            $dto = new ProductStockDTO(
                product_id: $this->productDTO['product_id'],
                quantity: $this->productDTO['stock']
            );

            $action->execute($dto);
        } else {
            throw new StockNotCreatedException();
        }
    }
}

