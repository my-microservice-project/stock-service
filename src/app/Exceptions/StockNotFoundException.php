<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class StockNotFoundException extends BaseException
{
    public function __construct(int $productId)
    {
        $message = sprintf('%s (Product ID: %d)', __('messages.stock_not_found'), $productId);
        parent::__construct($message, Response::HTTP_NOT_FOUND);
    }

}
