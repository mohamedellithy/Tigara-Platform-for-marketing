<?php
namespace App\Repositories;
use App\Interfaces\MerchantProductsRepositoryInterface;
use App\Models\Product;
use App\Models\Merchant;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Merchant as MerchantResource;
use App\Http\Resources\MerchantCollections as MerchantCollectionsResource;
use Illuminate\Http\Request;
class MerchantProductsRepository extends MerchantProductsRepositoryInterface{

    public function all(Request $request){
        if($request->has('filter_products')):
            $request->query('filter_products') == 1 ? $order_by = 'desc' : $order_by = 'asc';
            return response()->json([
                'data_info'          => $request->user()->products()->withCount('order_details')->orderBy('order_details_count',$order_by)->paginate(15),
                'active_products'    => $request->user()->products()->count(),
                'finished_products'  => $request->user()->products()->where('quantity',0)->count()
            ]);
        else:
            return response()->json([
                'data_info'          => $request->user()->products()->withCount('order_details')->paginate(15),
                'active_products'    => $request->user()->products()->count(),
                'finished_products'  => $request->user()->products()->where('quantity',0)->count()
            ]);
        endif;
    }

    public function search(Request $request){
        return response()->json([
            'data_info'          => $request->user()->products()->withCount('order_details')->where('name','Like','%'.$request->query('q').'%')->get(),
            'active_merchant'    => $request->user()->products()->where('status',1)->where('name','Like','%'.$request->query('q').'%')->count(),
            'no_active_merchant' => $request->user()->products()->where('status',0)->where('name','Like','%'.$request->query('q').'%')->count()
        ]);

    }

    public function show(Request $request,$id){
        return response()->json([
            'product'          => $request->user()->products()->withCount('order_details')->where('id',$id)->first()
        ]);
    }

    public function lowstock_products(Request $request){
        return response()->json([
            'data_info'  => $request->user()->products()->where('quantity',0)->paginate(5),
            'finished_products' => $request->user()->products()->where('quantity',0)->count()
        ]);
    }

    public function about_to_out_products(Request $request){
        return response()->json([
            'data_info'  => $request->user()->products()->where('quantity','<=',5)->paginate(15),
            'about_to_out_products' => $request->user()->products()->where('quantity','<=',5)->count()
        ]);
    }
}
