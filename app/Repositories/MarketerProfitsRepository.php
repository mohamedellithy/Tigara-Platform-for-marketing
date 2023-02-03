<?php
namespace App\Repositories;
use App\Interfaces\MarketerProfitsRepositoryInterface;
use App\Models\Marketer;
use App\Models\MarketerPayment;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Resources\Marketer as MarketerResource;
use App\Http\Resources\MarketerPayment as MarketerPaymentResource;
use App\Http\Resources\Product as ProductResource;
class MarketerProfitsRepository extends MarketerProfitsRepositoryInterface{

    public function profits_all(){
        return response()->json([
            'data_info'         => new MarketerResource(Marketer::with('products','orders')->whereHas('orders')->paginate(3)),
            'active_marketers'  => Marketer::whereHas('orders')->where('status',1)->count(),
            'products'          => '1234',
            'orders'            => '341234',
            'profits'           => '741234',
        ]);
    }

    public function search_profits($search = null){
        return response()->json([
            'data_info'          => MarketerResource::collection(Marketer::with('products','orders')->whereHas('orders')->where('name','Like','%'.$search.'%')->get()),
            'active_marketers'    => Marketer::with('products','orders')->whereHas('orders')->where('status',1)->where('name','Like','%'.$search.'%')->count(),
            'no_active_marketers' => Marketer::with('products','orders')->whereHas('orders')->where('status',0)->where('name','Like','%'.$search.'%')->count()
        ]);
    }

    public function payments_all(){
        return response()->json([
            'data_info'         => new MarketerPaymentResource(MarketerPayment::with('marketer')->paginate(3)),
            'active_marketers'  => '6586',
            'products'          => '1234',
            'orders'            => '341234',
            'profits'           => '741234',
        ]);
    }

    public function search_payments($search = null){
        return response()->json([
            'data_info'          => MarketerResource::collection(Marketer::with('products','orders')->whereHas('orders')->where('name','Like','%'.$search.'%')->get()),
            'active_marketers'    => Marketer::with('products','orders')->whereHas('orders')->where('status',1)->where('name','Like','%'.$search.'%')->count(),
            'no_active_marketers' => Marketer::with('products','orders')->whereHas('orders')->where('status',0)->where('name','Like','%'.$search.'%')->count()
        ]);
    }

    public function marketer_payments_update_type($data){
        $update_payment = MarketerPayment::whereIn('id',$data['ids'])->update([
            'payment_status' => $data['update_status']
        ]);

        if($update_payment):
            return response()->json([
                'result' => 'تم تعديل  بنجاح'
            ]);
        endif;
    }
}
