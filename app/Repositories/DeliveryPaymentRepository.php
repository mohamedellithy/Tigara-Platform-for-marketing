<?php
namespace App\Repositories;
use App\Interfaces\DeliveryPaymentRepositoryInterface;
use App\Models\Delivery;
use App\Models\DeliveryPayment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Resources\DeliveryPayment as DeliveryPaymentResource;
use App\Http\Resources\Delivery as DeliveryResource;
use App\Http\Resources\MerchantCollections as MerchantCollectionsResource;
class DeliveryPaymentRepository extends DeliveryPaymentRepositoryInterface{

    public function all(Request $request){
       // return response()->json(['data' => $request->all()]);
        if($request->has('delivery_id')):
            return response()->json([
                'data_info'          => new DeliveryPaymentResource(DeliveryPayment::where('delivery_id', $request->query('delivery_id'))->paginate(10))
            ]);
        else:
            $payment_made = DeliveryPayment::where('type',1)->sum('value');
            $payment_total = DeliveryPayment::where('type',0)->sum('value');
            return response()->json([
                'data_info'          => new MerchantCollectionsResource(Delivery::whereHas('delivery_payments')->with('delivery_payments')->paginate(2)),
                'payment_total'      => $payment_total,
                'payment_due'        => ($payment_total - $payment_made),
                'payment_made'       => $payment_made,
            ]);
        endif;
    }

    public function search($search = null){
        return response()->json([
            'data_info'          => DeliveryResource::collection(Delivery::whereHas('delivery_payments')->where('name','Like','%'.$search.'%')->get()),
            'active_merchant'    => Delivery::whereHas('delivery_payments')->where('status',1)->where('name','Like','%'.$search.'%')->count(),
            'no_active_merchant' => Delivery::whereHas('delivery_payments')->where('status',0)->where('name','Like','%'.$search.'%')->count()
        ]);

    }

    public function save($data){
        $add_new_merchant_payment = DeliveryPayment::create([
            'delivery_id'          => $data['delivery_id'],
            'value'         => $data['value'],
            'type'          => $data['type']
        ]);

        if($add_new_merchant_payment):
            return response()->json([
                'result' => 'تم اضافة المدفوعات بنجاح'
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
            $delete_merchant = $delivery->delete();
            if($delete_merchant):
                return response()->json([
                    'result' => 'تم حذف حساب تاجر بنجاح'
                ]);
            endif;
        endif;
    }

    public function delete_items($data){
        if($data['type'] == 'all'):
            $remove_merchant = Delivery::truncate();
        else:
            $remove_merchant = Delivery::destroy($data['deliveries']);
        endif;

        if($remove_merchant):
            return response()->json([
                'result' => 'تم حذف بنجاح'
            ]);
        endif;
    }
}
