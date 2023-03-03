<?php
namespace App\Repositories;
use App\Interfaces\MarketerFavouritsRepositoryInterface;
use App\Models\Product;
use App\Models\Merchant;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Merchant as MerchantResource;
use App\Http\Resources\MerchantCollections as MerchantCollectionsResource;
use Illuminate\Http\Request;
class MarketerFavouritsRepository extends MarketerFavouritsRepositoryInterface{

    public function all(Request $request){
        if($request->has('filter_products')):
            $request->query('filter_products') == 1 ? $order_by = 'desc' : $order_by = 'asc';
            return response()->json([
                'data_info'          => $request->user()->products_favourits()->paginate(5),
                'active_products'    => $request->user()->products_favourits()->count(),
                'finished_products'  => $request->user()->products_favourits()->where('quantity',0)->count()
            ]);
        else:
            return response()->json([
                'data_info'          => $request->user()->products_favourits()->paginate(5),
                'active_products'    => $request->user()->products_favourits()->count(),
                'finished_products'  => $request->user()->products_favourits()->where('quantity',0)->count()
            ]);
        endif;
    }

    public function save(Request $request){
        $request->user()->favourites()->updateOrCreate(
            ['marketer_id'  => $request->user()->id,
            'product_id'   => $request->input('product_id')
        ]);

        return response()->json([
           'success' => true
        ]);
    }

    public function search(Request $request){
        return response()->json([
            'data_info'          => $request->user()->products()->withCount('order_details')->where('name','Like','%'.$request->query('q').'%')->get(),
            'active_merchant'    => $request->user()->products()->where('status',1)->where('name','Like','%'.$request->query('q').'%')->count(),
            'no_active_merchant' => $request->user()->products()->where('status',0)->where('name','Like','%'.$request->query('q').'%')->count()
        ]);

    }


    public function delete(Request $request , $id){
        $request->user()->favourites()->where([
            'product_id'   => $id
        ])->delete();

        return response()->json([
           'success' => true
        ]);
    }
}
