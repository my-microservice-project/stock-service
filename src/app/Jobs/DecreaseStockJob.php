<?php

namespace App\Jobs;

use App\Actions\DecreaseStockAction;
use App\Data\ProductStockDTO;
use App\Exceptions\StockNotCreatedException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class DecreaseStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public int $productId;
    public int $quantity;

    public function __construct(int $productId, int $quantity)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
    }


    /**
     * @throws StockNotCreatedException
     */
    public function handle(DecreaseStockAction $action): void
    {
        if (!empty($this->productId) && isset($this->quantity)) {
            $dto = new ProductStockDTO(
                product_id: $this->productId,
                quantity: $this->quantity
            );

            $action->execute($dto);
        } else {
            throw new StockNotCreatedException();
        }
    }


}

