<?php

namespace App\Providers;

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
        //
        $this->app->bind('App\Interfaces\MerchantRepositoryInterface', 'App\Repositories\MerchantRepository');
        $this->app->bind('App\Interfaces\MerchantPaymentRepositoryInterface', 'App\Repositories\MerchantPaymentRepository');
        $this->app->bind('App\Interfaces\DeliveryRepositoryInterface', 'App\Repositories\DeliveryRepository');
        $this->app->bind('App\Interfaces\DeliveryPaymentRepositoryInterface', 'App\Repositories\DeliveryPaymentRepository');
        $this->app->bind('App\Interfaces\ProductRepositoryInterface', 'App\Repositories\ProductRepository');
        $this->app->bind('App\Interfaces\MarketerRepositoryInterface', 'App\Repositories\MarketerRepository');
        $this->app->bind('App\Interfaces\OrderRepositoryInterface', 'App\Repositories\OrderRepository');
        $this->app->bind('App\Interfaces\MarketerProfitsRepositoryInterface', 'App\Repositories\MarketerProfitsRepository');
        $this->app->bind('App\Interfaces\MerchantProductsRepositoryInterface','App\Repositories\MerchantProductsRepository');
        $this->app->bind('App\Interfaces\MerchantOrdersRepositoryInterface','App\Repositories\MerchantOrdersRepository');
        $this->app->bind('App\Interfaces\MerchantDueMadePaymentsRepositoryInterface', 'App\Repositories\MerchantDueMadePaymentsRepository');
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
