<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\Marketer;
use App\Models\Delivery;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    //

    public function index(){
        $marketer_profits = Order::where('order_status',2)->sum('marketer_profit');
        $all_marketer_and_platform_orders_profits = Order::where('order_status',2)
            ->join('order_details','orders.id','=','order_details.order_id')
            ->join('products','order_details.product_id','=','products.id')
            ->select('orders.*','order_details.unit_price','order_details.quantity','products.merchant_commission')
            ->sum(DB::Raw('(order_details.unit_price - products.merchant_commission) * order_details.quantity'));
        $total_from_delivery_profits =  Order::where('order_status',2)
                                        ->join('order_details','orders.id','=','order_details.order_id')->select('orders.*','order_details.unit_price','order_details.quantity')
                                        ->sum(DB::Raw('20 * (orders.cash_delivered - (order_details.unit_price * order_details.quantity)) / 100'));
        return response()->json([
            'merchants_count'    => Merchant::count(),
            'marketers_count'    => Marketer::count(),
            'deliveries_count'   => Delivery::count(),
            'products_count'     => Product::count(),
            'orders_count'       => Order::count(),
            'total_sales'        => OrderDetails::whereHas('order',function($query){
                                        $query->where('order_status',2);
                                    })->sum(DB::Raw('order_details.unit_price * order_details.quantity')),
            'total_sale_profits' => $all_marketer_and_platform_orders_profits -  $marketer_profits,
            'total_from_delivery_profits' => $total_from_delivery_profits,
            'all_profits'        => $total_from_delivery_profits + ($all_marketer_and_platform_orders_profits -  $marketer_profits),
            'orders'             => Order::with('marketer')->orderBy('created_at','asc')->limit(5)->get(),
            'products'           => Product::where('quantity',0)->orderBy('created_at','asc')->limit(5)->get(),
        ]);
    }
}
