<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Interfaces\MerchantDueMadePaymentsRepositoryInterface;
class MerchantDueMadePaymentsRepository extends MerchantDueMadePaymentsRepositoryInterface{
    public function due_payments(Request $request){
        return response()->json([
            'data_info'          => $request->user()->merchant_payments()->where('type','0')->paginate(10),
            'active_products'    => $request->user()->merchant_payments()->where('type','0')->count(),
            'finished_products'  => $request->user()->merchant_payments()->where('type','0')->count()
        ]);
    }

    public function made_payments(Request $request){
        return response()->json([
            'data_info'          => $request->user()->merchant_payments()->where('type','1')->paginate(10),
            'active_products'    => $request->user()->merchant_payments()->where('type','1')->count(),
            'finished_products'  => $request->user()->merchant_payments()->where('type','1')->count()
        ]);
    }
}
