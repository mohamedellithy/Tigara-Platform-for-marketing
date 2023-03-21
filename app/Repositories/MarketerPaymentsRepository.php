<?php
namespace App\Repositories;
use App\Interfaces\MarketerPaymentsRepositoryInterface;
use App\Models\Marketer;
use App\Models\MarketerPayment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class MarketerPaymentsRepository extends MarketerPaymentsRepositoryInterface{

    public function all(Request $request){
        return response()->json([
            'data_info'          => $request->user()->payments()->paginate(10),
            'total_profits'      => $request->user()->orders()->where('order_status',2)->sum('marketer_profit'),
            'total_payments'     => $request->user()->payments()->where('payment_status',1)->sum('value')
        ]);
    }

    public function save(Request $request){
        $add_new_payment = $request->user()->payments()->create([
            'value'                => $request->input('value'),
            'notice'               => $request->input('notice')
        ]);

        if($add_new_payment):
            return response()->json([
                'result' => 'تم اضافة المدفوعات بنجاح'
            ]);
        endif;
    }

    public function update(Request $request,$id){
        $request->user()->payments()->where('id',$id)->update($request->all());
        return response()->json([
            'result' => 'تم تعديل حساب تاجر بنجاح'
        ]);
           
    }
}
