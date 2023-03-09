<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Interfaces\MerchantDueMadePaymentsRepositoryInterface;
class MerchantDueMadePaymentsRepository extends MerchantDueMadePaymentsRepositoryInterface{
    public function due_payments(Request $request){
        return response()->json([
            'data_info'          => $request->user()->merchant_payments()->orderBy('created_at','desc')->with('item_details')->where('type','0')->paginate(10),
            'payments_total'     => $request->user()->payments_total,
            'payments_made'     => $request->user()->payments_made,
            'payments_due'     => $request->user()->payments_due,
        ]);
    }

    public function made_payments(Request $request){
        return response()->json([
            'data_info'          => $request->user()->merchant_payments()->orderBy('created_at','desc')->with('item_details')->where('type','1')->paginate(10),
            'payments_total'     => $request->user()->payments_total,
            'payments_made'     => $request->user()->payments_made,
            'payments_due'     => $request->user()->payments_due,
        ]);
    }
}
