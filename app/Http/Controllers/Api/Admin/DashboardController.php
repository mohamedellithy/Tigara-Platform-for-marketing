<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\Marketer;
use App\Models\Delivery;
use App\Models\Product;
use App\Models\Order;
class DashboardController extends Controller
{
    //

    public function index(){
        return response()->json([
            'merchants_count'    => Merchant::count(),
            'marketers_count'    => Marketer::count(),
            'deliveries_count'   => Delivery::count(),
            'products_count'     => Product::count(),
            'orders_count'       => Order::count(),
            'orders'             => Order::with('marketer')->orderBy('created_at','asc')->limit(5)->get(),
            'products'           => Product::with('merchant')->orderBy('created_at','asc')->limit(5)->get(),
        ]);
    }
}
