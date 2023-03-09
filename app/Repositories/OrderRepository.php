<?php
namespace App\Repositories;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use App\Http\Resources\Order as OrderResource;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Services\OrderActionsProcess;
class OrderRepository extends OrderRepositoryInterface{

    public function all(Request $request){
       // return response()->json(['data' => $request->all()]);
        if($request->has('merchant_id')):
            return response()->json([
                'data_info' => new OrderResource(Order::whereHas('order_details.product', function (Builder $query) use($request){
                    $query->where('merchant_id', $request->query('merchant_id'));
                })->with('delivery','marketer','order_details')->orderBy('created_at','desc')->paginate(2)),

                'active_orders'    => Order::whereHas('order_details.product', function (Builder $query) use($request){
                    $query->where('merchant_id', $request->query('merchant_id'));
                })->where('order_status',1)->count(),

                'no_active_orders' => Order::whereHas('order_details.product', function (Builder $query) use($request){
                    $query->where('merchant_id', $request->query('merchant_id'));
                })->where('order_status',0)->count()
            ]);
        elseif($request->has('marketer_id')):
            return response()->json([
                'data_info' => new OrderResource(Order::where('marketer_id', $request->query('marketer_id'))->with('delivery','marketer','order_details')->orderBy('created_at','desc')->paginate(2)),
                'active_orders'    => Order::where('marketer_id', $request->query('marketer_id'))->where('order_status',1)->count(),
                'no_active_orders' => Order::where('marketer_id', $request->query('marketer_id'))->where('order_status',0)->count()
            ]);
        elseif($request->has('delivery_id')):
            return response()->json([
                'data_info' => new OrderResource(Order::where('delivery_id', $request->query('delivery_id'))->with('delivery','marketer','order_details')->orderBy('created_at','desc')->paginate(5)),
                'active_orders'    => Order::where('delivery_id', $request->query('delivery_id'))->where('order_status',1)->count(),
                'no_active_orders' => Order::where('delivery_id', $request->query('delivery_id'))->where('order_status',0)->count()
            ]);
        else:
            return response()->json([
                'data_info'        => new OrderResource(Order::with('delivery','marketer','order_details')->orderBy('created_at','desc')->paginate(12)),
                'all_orders'       => Order::count(),
                'wait_orders'      => Order::where('order_status',0)->count(),
                'process_orders'   => Order::where('order_status',1)->count(),
                'complete_orders'  => Order::where('order_status',2)->count(),
                'refused_orders'   => Order::where('order_status',3)->count()
            ]);
        endif;
    }

    public function search(Request $request){
        if($request->has('merchant_id')):
            return response()->json([
                'data_info'          => OrderResource::collection(Order::whereHas('order_details.product', function (Builder $query) use($request){
                    $query->where('merchant_id', $request->query('merchant_id'));
                })->with('delivery','marketer','order_details')->where('id','Like','%'.$request->query('q').'%')->get()),
                'active_products'    => Order::where('order_status',1)->where('id','Like','%'.$request->query('q').'%')->count(),
                'no_active_products' => Order::where('order_status',0)->where('id','Like','%'.$request->query('q').'%')->count()
            ]);
        elseif($request->has('marketer_id')):
            return response()->json([
                'data_info'          => OrderResource::collection(Order::where('marketer_id', $request->query('marketer_id'))->with('delivery','marketer','order_details')->where('id','Like','%'.$request->query('q').'%')->get()),
                'active_products'    => Order::where('marketer_id', $request->query('marketer_id'))->where('order_status',1)->where('id','Like','%'.$request->query('q').'%')->count(),
                'no_active_products' => Order::where('marketer_id', $request->query('marketer_id'))->where('order_status',0)->where('id','Like','%'.$request->query('q').'%')->count()
            ]);
        elseif($request->has('delivery_id')):
            return response()->json([
                'data_info'          => OrderResource::collection(Order::where('delivery_id', $request->query('delivery_id'))->with('delivery','marketer','order_details')->where('id','Like','%'.$request->query('q').'%')->get()),
                'active_products'    => Order::where('delivery_id', $request->query('delivery_id'))->where('order_status',1)->where('id','Like','%'.$request->query('q').'%')->count(),
                'no_active_products' => Order::where('delivery_id', $request->query('delivery_id'))->where('order_status',0)->where('id','Like','%'.$request->query('q').'%')->count()
            ]);
        else:
            return response()->json([
                'data_info'          => OrderResource::collection(Order::with('delivery','marketer','order_details')->where('id','Like','%'.$request->query('q').'%')->get()),
                'active_products'    => Order::where('order_status',1)->where('id','Like','%'.$request->query('q').'%')->count(),
                'no_active_products' => Order::where('order_status',0)->where('id','Like','%'.$request->query('q').'%')->count()
            ]);
        endif;

    }

    public function show($id){
        return response()->json([
            'order'          => new OrderResource(Order::with('order_details','delivery','marketer')->find($id))
        ]);
    }

    public function update($data,$id){
        $order = Order::find($id);
        $order_shipping_status = $order->shipping_status;
        $order_status          = $order->order_status;
        if($order):
            $update_new_order = $order->update($data);

            if($order_status !=  $data['order_status']):
                $order_process = new OrderActionsProcess($order);
                $order_process->prev_status_order = $order_status;
                $order_process->handle_process_order_status();
            endif;

            return response()->json([
                'result' => 'تم تعديل الطلب بنجاح'
            ]);
        endif;
    }

    public function bulk_update($data){

        $update_product = Order::whereIn('id',$data['ids'])->update([
            'order_status'    => $data['order_status'],
            'shipping_status' => $data['shipping_status'],
        ]);

        if($update_product):
            return response()->json([
                'result' => 'تم تحديث الطلب بنجاح'
            ]);
        endif;
    }

    public function delete($id){
        $product = Order::find($id);
        if($product):
            $delete_delivery = $product->delete();
            if($delete_delivery):
                return response()->json([
                    'result' => 'تم اضافة المنتج بنجاح'
                ]);
            endif;
        endif;
    }

    public function delete_items($data){
        if($data['type'] == 'all'):
            $remove_product = Order::truncate();
        else:
            $remove_product = Order::destroy($data['products']);
        endif;

        if($remove_product):
            return response()->json([
                'result' => 'تم حذف المنتج بنجاح'
            ]);
        endif;
    }
}