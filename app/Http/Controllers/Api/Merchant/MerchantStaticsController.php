<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MerchantStaticsController extends Controller
{
    //
    public function index(Request $request){
        return response()->json([
            'products_count'          => $request->user()->products()->count(),
            'lowstock_products_count' => $request->user()->products()->where('quantity',0)->count(),
            'orders_count'            => $request->user()->order_details()->count(),
            'total_sales'             => $request->user()->total_merchant_products_sales,
            'payments_total'          => $request->user()->payments_total,
            'payments_due'            => $request->user()->payments_due,
            'payments_made'           => $request->user()->payments_made,
            'orders'                  => $request->user()->order_details()->orderBy('created_at','asc')->limit(5)->get(),
            'products'                => $request->user()->products()->where('quantity',0)->orderBy('created_at','asc')->limit(5)->get(),
        ]);
    }
}
