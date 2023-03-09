<?php
namespace App\Repositories;
use App\Interfaces\MerchantPaymentRepositoryInterface;
use App\Models\Merchant;
use App\Models\MerchantPayment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Resources\MerchantPayment as MerchantPaymentResource;
use App\Http\Resources\Merchant as MerchantResource;
use App\Http\Resources\MerchantCollections as MerchantCollectionsResource;
class MerchantPaymentRepository extends MerchantPaymentRepositoryInterface{

    public function all(Request $request){
       // return response()->json(['data' => $request->all()]);
        if($request->has('merchant_id')):
            return response()->json([
                'data_info'          => new MerchantPaymentResource(MerchantPayment::where('merchant_id', $request->query('merchant_id'))->with('item_details')->paginate(15))
            ]);
        else:
            $payment_made = MerchantPayment::where('type',1)->sum('value');
            $payment_total = MerchantPayment::where('type',0)->sum('value');
            return response()->json([
                'data_info'          => new MerchantCollectionsResource(Merchant::whereHas('merchant_payments')->with('merchant_payments')->paginate(15)),
                'payment_total'      => $payment_total,
                'payment_due'        => ($payment_total - $payment_made),
                'payment_made'       => $payment_made,
            ]);
        endif;
    }

    public function search($search = null){
        $payment_made = MerchantPayment::where('type',1)->sum('value');
        $payment_total = MerchantPayment::where('type',0)->sum('value');
        return response()->json([
            'data_info'          => MerchantResource::collection(Merchant::whereHas('merchant_payments')->where('name','Like','%'.$search.'%')->get()),
            'payment_total'      => $payment_total,
            'payment_due'        => ($payment_total - $payment_made),
            'payment_made'       => $payment_made,
        ]);

    }

    public function save($data){
        $add_new_merchant_payment = MerchantPayment::create([
            'merchant_id'   => $data['merchant_id'],
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
            'merchant'          => new MerchantResource(Merchant::find($id))
        ]);
    }

    public function update($data,$id){
        $merchant = Merchant::find($id);
        if($merchant):

            if(isset($data['password'])):
                $data['password'] = Hash::make($data['password']);
            endif;

            $add_new_merchant = $merchant->update($data);

            if($add_new_merchant):
                return response()->json([
                    'result' => 'تم تعديل حساب تاجر بنجاح'
                ]);
            endif;
        endif;
    }

    public function bulk_update($data){

        $update_merchant = Merchant::whereIn('id',$data['ids'])->update([
            'status' => $data['update_status']
        ]);

        if($update_merchant):
            return response()->json([
                'result' => 'تم تعديل  بنجاح'
            ]);
        endif;
    }

    public function delete($id){
        $merchant = Merchant::find($id);
        if($merchant):
            $delete_merchant = $merchant->delete();
            if($delete_merchant):
                return response()->json([
                    'result' => 'تم حذف حساب تاجر بنجاح'
                ]);
            endif;
        endif;
    }

    public function delete_items($data){
        if($data['type'] == 'all'):
            $remove_merchant = Merchant::truncate();
        else:
            $remove_merchant = Merchant::destroy($data['merchants']);
        endif;

        if($remove_merchant):
            return response()->json([
                'result' => 'تم حذف بنجاح'
            ]);
        endif;
    }
}
