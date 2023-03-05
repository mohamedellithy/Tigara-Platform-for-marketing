<?php
namespace App\Repositories;
use App\Interfaces\DeliveryRepositoryInterface;
use App\Models\Delivery;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Delivery as DeliveryResource;
use Illuminate\Http\Request;
class DeliveryRepository extends DeliveryRepositoryInterface{

    public function all(Request $request){
        if($request->query('paginate') == '-1'){
            $deliveries = new DeliveryResource(Delivery::all());
        } else {
            $deliveries = new DeliveryResource(Delivery::paginate(2));
        }
        return response()->json([
            'data_info'            => $deliveries,
            'active_deliveries'    => Delivery::where('status',1)->count(),
            'no_active_deliveries' => Delivery::where('status',0)->count()
        ]);
    }

    public function search($search = null){
        return response()->json([
            'data_info'          => DeliveryResource::collection(Delivery::where('name','Like','%'.$search.'%')->get()),
            'active_deliveries'    => Delivery::where('status',1)->where('name','Like','%'.$search.'%')->count(),
            'no_active_deliveries' => Delivery::where('status',0)->where('name','Like','%'.$search.'%')->count()
        ]);

    }

    public function save($data){
        $add_new_delivery = Delivery::create([
            'name'          => $data['name'],
            'phone'         => $data['phone'],
            'email'         => $data['email'],
            'account_type'  => $data['account_type'] ?: 2,
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
