<?php
namespace App\Repositories;
use App\Interfaces\MarketerProfitsRepositoryInterface;
use App\Models\Marketer;
use App\Models\MarketerPayment;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Resources\Marketer as MarketerResource;
use App\Http\Resources\MarketerPayment as MarketerPaymentResource;
use App\Http\Resources\Product as ProductResource;
use App\Models\OrderDetails;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
class MarketerProfitsRepository extends MarketerProfitsRepositoryInterface{

    public function profits_all(){
        $startDate = now()->subDays('7');
        return response()->json([
            'data_info'         => new MarketerResource(Marketer::with('products','orders')->whereHas('orders')->paginate(3)),
            'active_marketer'   => Marketer::whereHas('orders',function($query){
                $query->where('order_status',1);
            })->count(),
            'total_orders'      => Order::OrdersOfOrderStatus(2)->count(),
            'total_sales'       => Order::OrdersOfOrderStatus(2)->join('order_details','orders.id','=','order_details.order_id')->sum(DB::raw('unit_price * quantity')),
            'profits'           => Order::sum('marketer_profit'),
            'pending_profits'   => Order::OrdersOfOrderStatus(2)->where('created_at','>=',$startDate)->sum('marketer_profit'),
        ]);
    }

    public function search_profits($search = null){
        return response()->json([
            'data_info'          => MarketerResource::collection(Marketer::with('products','orders')->whereHas('orders')->where('name','Like','%'.$search.'%')->get()),
            'active_marketers'    => Marketer::with('products','orders')->whereHas('orders')->where('status',1)->where('name','Like','%'.$search.'%')->count(),
            'no_active_marketers' => Marketer::with('products','orders')->whereHas('orders')->where('status',0)->where('name','Like','%'.$search.'%')->count()
        ]);
    }

    public function payments_all(){
        $startDate = now()->subDays('7');
        $payment_make  = MarketerPayment::where('payment_status',1)->sum('value');
        $payment_due = MarketerPayment::where('payment_status',0)->sum('value');
        return response()->json([
            'data_info'         => new MarketerPaymentResource(MarketerPayment::with('marketer')->paginate(15)),
            'active_marketers'  => Marketer::whereHas('payments')->count(),
            'payments_due'      => Order::sum('marketer_profit') - $payment_make,
            'payments_make'     => $payment_make,
            'profits'           => Order::sum('marketer_profit'),
            'pending_profits'   => Order::OrdersOfOrderStatus(2)->where('created_at','>=',$startDate)->sum('marketer_profit'),
        ]);
    }

    public function search_payments($search = null){
        return response()->json([
            'data_info'          => MarketerResource::collection(Marketer::with('products','orders')->whereHas('orders')->where('name','Like','%'.$search.'%')->get()),
            'active_marketers'    => Marketer::with('products','orders')->whereHas('orders')->where('status',1)->where('name','Like','%'.$search.'%')->count(),
            'no_active_marketers' => Marketer::with('products','orders')->whereHas('orders')->where('status',0)->where('name','Like','%'.$search.'%')->count()
        ]);
    }

    public function marketer_payments_update_type($data){
        $update_payment = MarketerPayment::whereIn('id',$data['ids'])->update([
            'payment_status' => $data['update_status']
        ]);

        if($update_payment):
            return response()->json([
                'result' => 'تم تعديل  بنجاح'
            ]);
        endif;
    }
}
