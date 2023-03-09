<?php

namespace App\Http\Controllers\Api\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryStaticsController extends Controller
{
    //

    public function index(Request $request){
        return response()->json([
            'orders_count'            => $request->user()->orders()->count(),
            'orders_wait_count'       => $request->user()->orders()->where('shipping_status',0)->count(),
            'orders_process_count'    => $request->user()->orders()->where('shipping_status',1)->count(),
            'orders_completed_count'  => $request->user()->orders()->where('shipping_status',2)->count(),
            'orders_cancelled_count'  => $request->user()->orders()->where('shipping_status',3)->count(),
            'orders_returned_count'   => $request->user()->orders()->where('shipping_status',4)->count(),
            'total_sales'             => $request->user()->total_sales,
            'payments_total'          => $request->user()->payments_total,
            'payments_due'            => $request->user()->payments_due,
            'payments_made'           => $request->user()->payments_made,
            'orders'                  => $request->user()->orders()->orderBy('created_at','asc')->limit(5)->get(),
        ]);
    }
}