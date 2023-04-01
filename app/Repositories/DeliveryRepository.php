<?php
namespace App\Repositories;
use App\Interfaces\DeliveryRepositoryInterface;
use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Delivery as DeliveryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DeliveryRepository extends DeliveryRepositoryInterface{

    public function all(Request $request){
        if($request->query('paginate') == '-1'){
            $deliveries = new DeliveryResource(Delivery::all());
        } else {
            if($request->query('delivery_profits') == true){
                $deliveries = new DeliveryResource(Delivery::whereHas('orders',function($query){
                    $query->OrdersOfDeliveryStatus(2);
                })->paginate(15));
            } else {
                $deliveries = new DeliveryResource(Delivery::paginate(15));
            }
        }
        return response()->json([
            'data_info'            => $deliveries,
            'all_deliveries'       => Delivery::count(),
            'active_deliveries'    => Delivery::where('status',1)->count(),
            'total_delivery_profits' => Order::OrdersOfOrderStatus(2)
            ->WithOrderDetails()->sum(DB::Raw('(orders.cash_delivered - (order_details.unit_price * order_details.quantity)) - (20 * (orders.cash_delivered - (order_details.unit_price * order_details.quantity)) / 100)')),

            'total_profits'          =>  Order::OrdersOfOrderStatus(2)
            ->withOrderDetails()->sum(DB::Raw('(orders.cash_delivered - (order_details.unit_price * order_details.quantity))')),
        
            'total_platform_profits' => Order::OrdersOfOrderStatus(2)
            ->WithOrderDetails()->sum(DB::Raw('20 * (orders.cash_delivered - (order_details.unit_price * order_details.quantity)) / 100'))
        ]);
    }

    public function search(Request $request){
        if($request->query('delivery_profits') == true):
            $delivery = Delivery::whereHas('orders',function($query){
                $query->OrdersOfOrderStatus(2);
            })->where('name','Like','%'.$request->query('q').'%')->get();
        else:
            $delivery = Delivery::where('name','Like','%'.$request->query('q').'%')->get();
        endif;
        return response()->json([
            'data_info'          => DeliveryResource::collection($delivery),
            'active_deliveries'    => Delivery::where('status',1)->where('name','Like','%'.$request->query('q').'%')->count(),
            'no_active_deliveries' => Delivery::where('status',0)->where('name','Like','%'.$request->query('q').'%')->count()
        ]);

    }

    public function save($data){
        $add_new_delivery = Delivery::create([
            'name'          => $data['name'],
            'phone'         => $data['phone'],
            'email'         => $data['email'],
            'account_type'  => 2,
            'status'        => $data['status'] ?: 1,
            'password'      => Hash::make($data['password']),
        ]);

        if($add_new_delivery):
            return response()->json([
                'result' => 'تم انشاء حساب تاجر بنجاح'
            ]);
        endif;
    }

    public function show($id){
        return response()->json([
            'delivery'          => new DeliveryResource(Delivery::find($id))
        ]);
    }

    public function update($data,$id){
        $delivery = Delivery::find($id);
        if($delivery):

            if(isset($data['password'])):
                $data['password'] = Hash::make($data['password']);
            endif;

            $add_new_merchant = $delivery->update($data);
       
            if($add_new_merchant):
                return response()->json([
                    'result' => 'تم تعديل حساب تاجر بنجاح'
                ]);
            endif;
        endif;
    }

    public function bulk_update($data){
        
        $update_delivery = Delivery::whereIn('id',$data['ids'])->update([
            'status' => $data['update_status']
        ]);
    
        if($update_delivery):
            return response()->json([
                'result' => 'تم تعديل  بنجاح'
            ]);
        endif;
    }

    public function delete($id){
        $delivery = Delivery::find($id);
        if($delivery):
            $delete_delivery = $delivery->delete();
            if($delete_delivery):
                return response()->json([
                    'result' => 'تم حذف حساب تاجر بنجاح'
                ]);
            endif;
        endif;
    }

    public function delete_items($data){
        if($data['type'] == 'all'):
            $remove_delivery = Delivery::truncate();
        else:
            $remove_delivery = Delivery::destroy($data['deliveries']);
        endif;

        if($remove_delivery):
            return response()->json([
                'result' => 'تم حذف بنجاح'
            ]);
        endif;
    }
}
