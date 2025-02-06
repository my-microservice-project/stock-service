<?php

namespace App\Enums;

enum QueueEnum: string
{

    case PRODUCT_ELASTIC_UPDATE = 'Product_Elastic_Update';

    public function getValue(): string
    {
        return $this->value;
    }
}
