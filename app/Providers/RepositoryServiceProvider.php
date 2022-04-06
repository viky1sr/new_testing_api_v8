<?php

namespace App\Providers;

use App\Repositories\Interfaces\LogPembelianCustomerInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\LogPembelianCustomerCacheRepository;
use App\Repositories\ProductCacheRepository;
use App\Repositories\UserCacheRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class , UserCacheRepository::class);
        $this->app->bind(ProductRepositoryInterface::class , ProductCacheRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
