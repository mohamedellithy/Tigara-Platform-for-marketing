<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Interfaces\DeliveryDueMadePaymentsRepositoryInterface;
class DeliveryDueMadePaymentsRepository extends DeliveryDueMadePaymentsRepositoryInterface{
    public function due_payments(Request $request){
        $total_profits = $request->user()->delivery_payments()->where('type','0')->sum('value');
        $payment_made  = $request->user()->delivery_payments()->where('type','1')->sum('value');
        $payment_due   = $total_profits - $payment_made;
        return response()->json([
            'data_info'          => $request->user()->delivery_payments()->with('order')->where('type','0')->paginate(10),
            'total_profits'      => $total_profits,
            'payment_due'        => $payment_due,
            'payment_made'       => $payment_made
        ]);
    }

    public function made_payments(Request $request){
        $total_profits = $request->user()->delivery_payments()->where('type','0')->sum('value');
        $payment_made  = $request->user()->delivery_payments()->where('type','1')->sum('value');
        $payment_due   = $total_profits - $payment_made;
        return response()->json([
            'data_info'          => $request->user()->delivery_payments()->with('order')->where('type','1')->paginate(10),
            'total_profits'      => $total_profits,
            'payment_due'        => $payment_due,
            'payment_made'       => $payment_made
        ]);
    }
}
