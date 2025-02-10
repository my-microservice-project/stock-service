<?php

namespace App\Enums;

enum QueueEnum: string
{

    case PRODUCT_ELASTIC_UPDATE = 'Product_Elastic_Update';
    case DECREASE_STOCK = 'Decrease_Stock';

    public function getValue(): string
    {
        return $this->value;
    }
}
