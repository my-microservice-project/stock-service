<?php

namespace App\Listeners;

use App\Enums\QueueEnum;
use App\Events\StockUpdatedEvent;
use App\Jobs\ProductElasticUpdateJob;

class StockUpdatedListener
{
    public function handle(StockUpdatedEvent $event): void
    {
        ProductElasticUpdateJob::dispatch($event->productId)->onQueue(QueueEnum::PRODUCT_ELASTIC_UPDATE->getValue());
    }
}
