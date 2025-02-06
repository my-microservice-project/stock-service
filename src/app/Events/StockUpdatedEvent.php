<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class StockUpdatedEvent
{
    use Dispatchable;

    public function __construct(public int $productId) {}

}
