<?php

namespace App\Providers;

use App\Repositories\Contracts\ProductStockRepositoryInterface;
use App\Repositories\ProductStockRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductStockRepositoryInterface::class, ProductStockRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
