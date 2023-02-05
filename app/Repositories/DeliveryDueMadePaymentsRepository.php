<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Interfaces\DeliveryDueMadePaymentsRepositoryInterface;
class DeliveryDueMadePaymentsRepository extends DeliveryDueMadePaymentsRepositoryInterface{
    public function due_payments(Request $request){
        return response()->json([
            'data_info'          => $request->user()->delivery_payments()->where('type','0')->paginate(10),
            'active_products'    => $request->user()->delivery_payments()->where('type','0')->count(),
            'finished_products'  => $request->user()->delivery_payments()->where('type','0')->count()
        ]);
    }

    public function made_payments(Request $request){
        return response()->json([
            'data_info'          => $request->user()->delivery_payments()->where('type','1')->paginate(10),
            'active_products'    => $request->user()->delivery_payments()->where('type','1')->count(),
            'finished_products'  => $request->user()->delivery_payments()->where('type','1')->count()
        ]);
    }
}
