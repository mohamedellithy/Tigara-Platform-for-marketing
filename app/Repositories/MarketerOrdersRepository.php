<?php
namespace App\Repositories;
use App\Interfaces\MarketerOrdersRepositoryInterface;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Services\OrderActionsProcess;
use Illuminate\Support\Facades\DB;
use App\Services\StockService;
class MarketerOrdersRepository extends MarketerOrdersRepositoryInterface{

    public function all(Request $request){
        return response()->json([
            'data_info'        => $request->user()->orders()->orderBy('created_at','desc')->paginate(10),
            'all_orders'       => $request->user()->orders()->count(),
            'wait_orders'      => $request->user()->orders()->where('order_status',0)->count(),
            'process_orders'   => $request->user()->orders()->where('order_status',1)->count(),
            'complete_orders'  => $request->user()->orders()->where('order_status',2)->count(),
            'refused_orders'   => $request->user()->orders()->where('order_status',3)->count(),
            'total_costs'      => $request->user()->orders()->where('orders.order_status',2)->join('order_details', 'orders.id','=','order_details.order_id')
            ->select('orders.*','order_details.quantity','order_details.unit_price')->groupby('orders.id')->sum(DB::Raw('order_details.quantity * order_details.unit_price')),
            'total_profits'    => $request->user()->orders()->where('orders.order_status',2)->sum('marketer_profit')]);
    }

    public function save(Request $request){
        $customer = Customer::updateOrCreate([
            'phone'      => $request->input('phone'),
        ],[
            'name'       => $request->input('name'),
            'city'       => $request->input('city'),
            'address'    => $request->input('address'),
            'notice'     => $request->input('notice')
        ]);

        if($customer){
            $order = $request->user()->orders()->create([
                'customer_id' => $customer->id
            ]);
        }

        if($order):

            foreach($request->user()->carts as $cart):

                $order->order_details()->create([
                    'product_id' => $cart->product_id,
                    'quantity'   => $cart->quantity,
                    'unit_price' => $cart->price
                ]);

                $cart->delete();

            endforeach;

            // process the order
            $order_process = new OrderActionsProcess(Order::find($order->id));
            $order_process->handle_process_order_status();

        endif;

        return response()->json([
            'order' => $order
        ]);
    }

    public function search(Request $request){
        return response()->json([
            'data_info'          => $request->user()->products()->where('name','Like','%'.$request->query('q').'%')->get(),
            'active_merchant'    => $request->user()->products()->where('status',1)->where('name','Like','%'.$request->query('q').'%')->count(),
            'no_active_merchant' => $request->user()->products()->where('status',0)->where('name','Like','%'.$request->query('q').'%')->count()
        ]);

    }

    public function show(Request $request,$id){
        return response()->json([
            'order'          => $request->user()->orders()->with('customer','order_details')->where('id',$id)->first()
        ]);
    }

    public function update(Request $request,$id){
        $query_order  = $request->user()->orders()->where('id',$id);

        $order_status = $query_order->first()->order_status;
        $update_order = $query_order->update($request->except(['order_details','customer']));

        if($request->has('order_status')):
            // process the order
            $order_process = new OrderActionsProcess($query_order->first());
            $order_process->prev_status_order = $order_status;

            // incase restore order cancelled
            // if($order_process->order_stock_availability() == false):
            //     return response()->json([
            //         'status' => 'كمية الطلبات غير متوفرة فى المخزن'
            //     ]);
            // endif;

            $order_process->handle_process_order_status();
        endif;

        if($request->has('order_details')):

            $order = $query_order->first();

            foreach($request->input('order_details') as $order_detail):

                $item_order = $order->order_details()->where('id',$order_detail['id']);

                // check stock availability
                $stock = new StockService(
                    Product::find($order_detail['product_id'])
                );

                if($order_detail['quantity'] > ( $old_quantity = $item_order->first()->quantity ) ):

                    // set quantity
                    $stock->required_quantity = intval($order_detail['quantity'] - $old_quantity);

                    if($stock->stock_availaibility() == false):
                        continue;
                    endif;

                    $stock->decrease_stock();

                elseif($order_detail['quantity'] < $old_quantity ):

                    // set quantity
                    $stock->required_quantity = intval($old_quantity - $order_detail['quantity']);

                    $stock->increase_stock();

                endif;

                $item_order->delete();
                $order->order_details()->create([
                    'product_id' => $order_detail['product_id'],
                    'quantity'   => $order_detail['quantity'],
                    'unit_price' => $order_detail['unit_price']
                ]);
            endforeach;
        endif;

        if($request->has('customer')):
            $order = $query_order->first();
            $customer = $request->input('customer');
            $order->customer()->where('id',$customer['id'])->update([
                'name' => $customer['name'],
                'phone' => $customer['phone'],
                'another_phone' => $customer['another_phone'],
                'city' => $customer['city'],
                'address' => $customer['address'],
                'notice' => $customer['notice']
            ]);
        endif;

        if($update_order):
            return response()->json([
                'result' => 'تم تعديل الطلب بنجاح',
                'order'  => $request->user()->orders()->with('customer','order_details')->where('id',$id)->first()
            ]);
        endif;
    }

    public function delete(Request $request,$id){}
}
