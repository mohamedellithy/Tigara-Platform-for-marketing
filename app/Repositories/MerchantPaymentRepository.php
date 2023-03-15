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
                'data_info'          => new MerchantPaymentResource(MerchantPayment::where('merchant_id', $request->query('merchant_id'))->with('item_details')->orderBy('created_at','desc')->paginate(15))
            ]);
        else:
            $payment_made    = MerchantPayment::where('type',1)->sum('value');
            $payment_total   = MerchantPayment::where('type',0)->sum('value');
            $payment_pending = MerchantPayment::where('item_id','!=',null)->where('created_at','>=',strtotime('-7 day',strtotime(date('d-m-Y'))))->sum('value');
            return response()->json([
                'data_info'          => new MerchantCollectionsResource(Merchant::whereHas('merchant_payments')->with('merchant_payments')->orderBy('created_at','desc')->paginate(15)),
                'payment_total'      => $payment_total,
                'payment_due'        => ($payment_total - $payment_made),
                'payment_made'       => $payment_made,
                'payment_pending'    => $payment_pending,
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

    // public function show($id){
    //     return response()->json([
    //         'merchant'          => new MerchantResource(Merchant::find($id))
    //     ]);
    // }

    public function update($data,$id){
        $merchant_payment = MerchantPayment::find($id);
        if($merchant_payment):

            $add_new_merchant = $merchant_payment->update($data);

            if($add_new_merchant):
                return response()->json([
                    'result' => 'تم تعديل المدفوعات بنجاح'
                ]);
            endif;
        endif;
    }

    // public function bulk_update($data){

    //     $update_merchant = MerchantPayment::whereIn('id',$data['ids'])->update([
    //         'status' => $data['update_status']
    //     ]);

    //     if($update_merchant):
    //         return response()->json([
    //             'result' => 'تم تعديل المدفوعات بنجاح'
    //         ]);
    //     endif;
    // }

    public function delete($id){
        $merchant_payment = MerchantPayment::find($id);
        if($merchant_payment):
            $delete_merchant_payment = $merchant_payment->delete();
            if($delete_merchant_payment):
                return response()->json([
                    'result' => 'تم حذف المدفوعات بنجاح'
                ]);
            endif;
        endif;
    }

    // public function delete_items($data){
    //     if($data['type'] == 'all'):
    //         $remove_merchant = Merchant::truncate();
    //     else:
    //         $remove_merchant = Merchant::destroy($data['merchants']);
    //     endif;

    //     if($remove_merchant):
    //         return response()->json([
    //             'result' => 'تم حذف بنجاح'
    //         ]);
    //     endif;
    // }
}
