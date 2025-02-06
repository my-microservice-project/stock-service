<?php

use App\Http\Controllers\V1\StockController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'stocks'], function () {
        Route::post('sync', [StockController::class, 'sync']);
        Route::get('{id}', [StockController::class, 'getStock']);
        Route::post('check-availability', [StockController::class, 'checkAvailability']);
    });
});
