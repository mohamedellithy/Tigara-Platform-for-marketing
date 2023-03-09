<?php
namespace App\Repositories;
use App\Interfaces\DeliveryOrdersRepositoryInterface;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\OrderActionsProcess;
class DeliveryOrdersRepository extends DeliveryOrdersRepositoryInterface{

    public function all(Request $request){
        $order_query = $request->user()->orders();
        // Dairy
        if($request->query('type') == '0'):
            $order_query = $order_query->where([
                'order_status'    => 1,
                'shipping_status' => 0
            ])->where('updated_at', '>=', Carbon::today()->toDateString());
        // wait
        elseif($request->query('type') == '1'):
            $order_query = $order_query->where([
                'order_status'    => 1,
                'shipping_status' => 0 // wait
            ]);
        // process
        elseif($request->query('type') == '2'):
            $order_query = $order_query->where([
                'order_status'    => 1,
                'shipping_status' => 1 // process
            ]);
        // completed
        elseif($request->query('type') == '3'):
            $order_query = $order_query->where([
                'shipping_status' => 2 // completed
            ]);
        // cancelled
        elseif($request->query('type') == '4'):
            $order_query = $order_query->where([
                'shipping_status' => 3 // cancelled
            ]);
        // returned
        elseif($request->query('type') == '5'):
            $order_query = $order_query->where([
                'shipping_status' => 4 // returned
            ]);
        endif;
        return response()->json([
            'data_info'          => $order_query->orderBy('created_at','desc')->paginate(10),
            'orders_count'       => $order_query->count()
        ]);
    }

    public function search(Request $request){
        return response()->json([
            'data_info'          => $request->user()->orders()->where('name','Like','%'.$request->query('q').'%')->get(),
            'active_merchant'    => $request->user()->orders()->where('status',1)->where('name','Like','%'.$request->query('q').'%')->count(),
            'no_active_merchant' => $request->user()->orders()->where('status',0)->where('name','Like','%'.$request->query('q').'%')->count()
        ]);
    }

    public function update($data,$id){
        $order = Order::find($id);
        $order_shipping_status = $order->shipping_status;
        $order_status          = $order->order_status;
        if($order):

            $data['order_status'] = $data['shipping_status'];

            $update_new_order = $order->update($data);

            if($update_new_order):
                // if(in_array($data['shipping_status'],["2"])):
                    if($order_shipping_status !=  $data['shipping_status']):
                        $order_process = new OrderActionsProcess($order);
                        $order_process->prev_status_order = $order_status;
                        $order_process->handle_process_order_status();
                    endif;
                // endif;
            endif;

            return response()->json([
                'result' => 'تم تعديل الطلب بنجاح',
                'order'  => $order,
                'shipping_status' => $order->shipping_status,
                'shipping_status_1'=>$order_shipping_status
            ]);
        endif;
    }

    public function bulk_update_status($data){

        $update_product = Order::whereIn('id',$data['ids'])->update([
            'shipping_status' => $data['shipping_status']
        ]);

        if($update_product):
            return response()->json([
                'result' => 'تم تحديث الطلب بنجاح'
            ]);
        endif;
    }

    public function show(Request $request,$id){
        return response()->json([
            'order'          => $request->user()->orders()->with('order_details','customer')->where('id',$id)->first()
        ]);
    }
}
