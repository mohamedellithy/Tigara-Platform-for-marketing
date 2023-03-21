<?php
namespace App\Repositories;
use App\Interfaces\MerchantOrdersRepositoryInterface;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
class MerchantOrdersRepository extends MerchantOrdersRepositoryInterface{

    public function all(Request $request){
        if($request->query('type') == 'wait'):
            $data_orders = $request->user()->order_details()->whereHas('order',function($query){
                $query->where('order_status',0);
            })->orderBy('created_at','desc')->with('order','merchant_payment')->paginate(15);

        elseif($request->query('type') == 'processing'):
            $data_orders = $request->user()->order_details()->whereHas('order',function($query){
                $query->where('order_status',1);
            })->orderBy('created_at','desc')->with('order','merchant_payment')->paginate(15);

        elseif($request->query('type') == 'completed'):
            $data_orders = $request->user()->order_details()->whereHas('order',function($query){
                $query->where('order_status',2);
            })->orderBy('created_at','desc')->with('order','merchant_payment')->paginate(15);

        elseif($request->query('type') == 'refused'):
            $data_orders = $request->user()->order_details()->whereHas('order',function($query){
                $query->where('order_status',3);
            })->orderBy('created_at','desc')->with('order','merchant_payment')->paginate(15);

        elseif($request->query('type') == 'cancelled'):
            $data_orders = $request->user()->order_details()->whereHas('order',function($query){
                $query->where('order_status',4);
            })->orderBy('created_at','desc')->with('order','merchant_payment')->paginate(15);
            
        else:
            $data_orders = $request->user()->orders()->orderBy('created_at','desc')->with('order','merchant_payment')->paginate(15);
        endif;

        return response()->json([
            'data_info'        => $data_orders,
            'all_orders'       => $request->user()->order_details()->count(),
            'wait_orders'      => $request->user()->order_details()->whereHas('order',function($query){
                $query->where('order_status',0);
            })->count(),
            'process_orders'   => $request->user()->order_details()->whereHas('order',function($query){
                $query->where('order_status',1);
            })->count(),
            'complete_orders'  => $request->user()->order_details()->whereHas('order',function($query){
                $query->where('order_status',2);
            })->count(),
            'refused_orders'   => $request->user()->order_details()->whereHas('order',function($query){
                $query->where('order_status',3);
            })->count(),
        ]);
    }

    public function search(Request $request){
        return response()->json([
            'data_info'          => $request->user()->products()->where('name','Like','%'.$request->query('q').'%')->get(),
            'active_merchant'    => $request->user()->products()->where('status',1)->where('name','Like','%'.$request->query('q').'%')->count(),
            'no_active_merchant' => $request->user()->products()->where('status',0)->where('name','Like','%'.$request->query('q').'%')->count()
        ]);

    }

    public function save(Request $request){
        return response()->json([
            'data_info'          => $request->user()->products()->where('name','Like','%'.$request->query('q').'%')->get(),
            'active_merchant'    => $request->user()->products()->where('status',1)->where('name','Like','%'.$request->query('q').'%')->count(),
            'no_active_merchant' => $request->user()->products()->where('status',0)->where('name','Like','%'.$request->query('q').'%')->count()
        ]);

    }

    public function show(Request $request,$id){
        return response()->json([
            'product'          => $request->user()->products()->where('id',$id)->first()
        ]);
    }
}
