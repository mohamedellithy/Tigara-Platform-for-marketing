<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\ApiAuthController;

/**
 * Admin Controller
 */
use App\Http\Controllers\Api\Admin\MerchantController;
use App\Http\Controllers\Api\Admin\MerchantPaymentController;
use App\Http\Controllers\Api\Admin\DeliveryController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\MarketerController;
use App\Http\Controllers\Api\Admin\OrderController;
use App\Http\Controllers\Api\Admin\MarketerProfitsController;
use App\Http\Controllers\Api\Admin\DeliveryPaymentController;
use App\Http\Controllers\Api\Admin\DashboardController;


/**
 * @merchants Controller
 */
use App\Http\Controllers\Api\Merchant\ProductController as MerchantProductController;
use App\Http\Controllers\Api\Merchant\OrderController as MerchantOrderController;
use App\Http\Controllers\Api\Merchant\PaymentsController as MerchantPaymentsController;
use App\Http\Controllers\Api\Merchant\MerchantStaticsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login',[ApiAuthController::class , 'login']);
Route::post('/register',[ApiAuthController::class , 'register']);


Route::domain('admin.'.env('MAIN_DOMAIN'))->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me',[ApiAuthController::class , 'me']);
        Route::post('/logout',[ApiAuthController::class , 'logout']);


        Route::get('/merchants/search',[MerchantController::class,'search']);
        Route::put('/merchants/update-status',[MerchantController::class,'bulk_update_status']);
        Route::delete('/merchants/delete-selected',[MerchantController::class,'truncate']);
        Route::apiResource('merchants',MerchantController::class);
        Route::get('/merchant-payments/search',[MerchantPaymentController::class,'search']);
        Route::apiResource('merchant-payments', MerchantPaymentController::class);


        Route::get('/deliveries/search',[DeliveryController::class,'search']);
        Route::put('/deliveries/update-status',[DeliveryController::class,'bulk_update_status']);
        Route::delete('/deliveries/delete-selected',[DeliveryController::class,'truncate']);
        Route::apiResource('deliveries',DeliveryController::class);
        Route::get('/delivery-payments/search',[DeliveryPaymentController::class,'search']);
        Route::apiResource('delivery-payments', DeliveryPaymentController::class);


        Route::get('/products/search',[ProductController::class,'search']);
        Route::put('/products/update-status',[ProductController::class,'bulk_update_status']);
        Route::delete('/products/delete-selected',[ProductController::class,'truncate']);
        Route::post('update-products/{id}',[ProductController::class,'update']);
        Route::apiResource('products',ProductController::class)->except([
            'update'
        ]);


        Route::get('/marketers/search',[MarketerController::class,'search']);
        Route::put('/marketers/update-status',[MarketerController::class,'bulk_update_status']);
        Route::delete('/marketers/delete-selected',[MarketerController::class,'truncate']);
        Route::post('/add-products-to-marketer/{id}', [MarketerController::class,'add_products_to_marketer']);
        Route::post('/remove-products-from-marketer/{id}', [MarketerController::class,'remove_products_from_marketer']);
        Route::get('/marketer-nothave-products/{id}', [MarketerController::class, 'marketer_nothave_products']);
        Route::get('/marketer-products/{id}', [MarketerController::class, 'marketer_products']);
        Route::apiResource('marketers',MarketerController::class)->except([
            'update','store'
        ]);
        Route::get('/marketer-profits', [MarketerProfitsController::class,'marketer_profits_index']);
        Route::get('/marketer-search-profits', [MarketerProfitsController::class,'marketer_search_profits']);
        Route::get('/marketer-payments-index', [MarketerProfitsController::class,'marketer_payments_index']);
        Route::get('/marketer-search-payments',[MarketerProfitsController::class,'marketer_search_payments']);
        Route::put('/marketers-payments',[MarketerProfitsController::class,'marketer_payments_update_type']);


        Route::get('/orders/search',[OrderController::class,'search']);
        Route::put('/orders/update-status',[OrderController::class,'bulk_update_status']);
        Route::apiResource('orders',OrderController::class);

        Route::get('/dashboard-statics', [DashboardController::class, 'index']);
    });
});



Route::domain('merchant.'.env('MAIN_DOMAIN'))->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me',[ApiAuthController::class , 'me']);
        Route::post('/logout',[ApiAuthController::class , 'logout']);
        Route::get('/products/search',[MerchantProductController::class,'search']);
        Route::get('/lowstock-products',[MerchantProductController::class,'lowstock_products']);
        Route::apiResource('products',MerchantProductController::class)->only([
            'index','show'
        ]);
        Route::apiResource('orders',MerchantOrderController::class)->only([
            'index','show'
        ]);

        Route::get('/merchant-due-payments',[MerchantPaymentsController::class,'due_payments']);
        Route::get('/merchant-made-payments',[MerchantPaymentsController::class,'made_payments']);
        Route::get('merchant-statics',[MerchantStaticsController::class,'index']);
    });
});
