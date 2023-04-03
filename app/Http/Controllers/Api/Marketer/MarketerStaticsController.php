<?php

namespace App\Http\Controllers\Api\Marketer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
class MarketerStaticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $profits =  $request->user()->orders()->where('orders.order_status',2)->sum('marketer_profit');
        $payments_made = $request->user()->payments()->where('payment_status',1)->sum('value');
        return response()->json([
            'products_count'          => Product::count(),
            'lowstock_products_count' => Product::where('quantity',0)->count(),
            'orders_count'            => $request->user()->orders()->count(),
            'total_sales'             => $request->user()->orders()->where('order_status',2)->join('order_details', 'orders.id','=','order_details.order_id')->select('orders.*','order_details.quantity','order_details.unit_price')->sum(DB::Raw('order_details.quantity * order_details.unit_price')),
            'total_profits'           => $profits,
            'payments_made'           => $payments_made,
            'payments_due'            => $profits - $payments_made,
            'orders_compeleted'       => $request->user()->orders()->where('order_status',2)->count(),
            'orders'                  => $request->user()->orders()->orderBy('created_at','asc')->limit(5)->get(),
            'products'                => Product::where('quantity',0)->orderBy('created_at','asc')->limit(5)->get()
        ]);
    }

    public function attach_marketing_details(Request $request){
         $request->user()->addition_informations()->updateOrCreate([
            'marketer_id' => $request->user()->id
         ],[
            'who_you' => $request->input('who_you'),
            'which_marketing_will_follow' => $request->input('which_marketing_will_follow'),
         ]);

        return response()->json([
            'status' => 'success',
            'result' => 'information added successfully'
        ]);
    }
}
