<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class StockNotCreatedException extends BaseException
{
    public function __construct()
    {
        parent::__construct('messages.stock_not_created', Response::HTTP_BAD_REQUEST);
    }
}
