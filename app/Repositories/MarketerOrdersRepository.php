<?php
namespace App\Repositories;
use App\Interfaces\MarketerOrdersRepositoryInterface;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
class MarketerOrdersRepository extends MarketerOrdersRepositoryInterface{

    public function all(Request $request){
        return response()->json([
            'data_info'          => $request->user()->orders()->paginate(10),
            'active_products'    => $request->user()->orders()->count(),
            'finished_products'  => $request->user()->orders()->count()
        ]);
    }

    public function save(Request $request){
        $customer = Customer::updateOrCreate([
            'phone'      => $request->input('phone'),
        ],[
            'name'       => $request->input('name'),
            'email'      => $request->input('email'),
            'city'       => $request->input('city'),
            'address'    => $request->input('address'),
            'notice'     => $request->input('notice')
        ]);

        if($customer){
            $order = $request->user()->orders()->create([
                'customer_id' => $customer->id
            ]);
        }

        if($order){
            foreach($request->user()->carts as $cart):
                $order->order_details()->create([
                    'product_id' => $cart->product_id,
                    'quantity'   => $cart->quantity,
                    'unit_price' => $cart->price
                ]);
                $cart->delete();
            endforeach;
        }

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
        $update_order = $request->user()->orders()->where('id',$id)->update($request->except(['order_details','customer']));

        if($request->has('order_details')):
            $order = $request->user()->orders()->where('id',$id)->first();
            foreach($request->input('order_details') as $order_detail):
                $order->order_details()->where('id',$order_detail['id'])->delete();
                $order->order_details()->create([
                    'product_id' => $order_detail['product_id'],
                    'quantity'   => $order_detail['quantity'],
                    'unit_price' => $order_detail['unit_price']
                ]);
            endforeach;
        endif;

        if($request->has('customer')):
            $order = $request->user()->orders()->where('id',$id)->first();
            $customer = $request->input('customer');
            $order->customer()->where('id',$customer['id'])->update([
                'name' => $customer['name'],
                'email' => $customer['email'],
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
