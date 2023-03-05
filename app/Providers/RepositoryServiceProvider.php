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
        $this->app->bind('App\Interfaces\DeliveryOrdersRepositoryInterface', 'App\Repositories\DeliveryOrdersRepository');
        $this->app->bind('App\Interfaces\DeliveryDueMadePaymentsRepositoryInterface', 'App\Repositories\DeliveryDueMadePaymentsRepository');
        $this->app->bind('App\Interfaces\MarketerProductsRepositoryInterface', 'App\Repositories\MarketerProductsRepository');
        $this->app->bind('App\Interfaces\MarketerCartRepositoryInterface', 'App\Repositories\MarketerCartRepository');
        $this->app->bind('App\Interfaces\MarketerOrdersRepositoryInterface', 'App\Repositories\MarketerOrdersRepository');
        $this->app->bind('App\Interfaces\MarketerFavouritsRepositoryInterface', 'App\Repositories\MarketerFavouritsRepository');
        $this->app->bind('App\Interfaces\MarketerPaymentsRepositoryInterface', 'App\Repositories\MarketerPaymentsRepository');
        
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
