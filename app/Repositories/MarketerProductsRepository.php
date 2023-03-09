<?php
namespace App\Repositories;
use App\Interfaces\MarketerProductsRepositoryInterface;
use App\Models\Product;
use App\Models\Merchant;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Merchant as MerchantResource;
use App\Http\Resources\MerchantCollections as MerchantCollectionsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MarketerProductsRepository extends MarketerProductsRepositoryInterface{

    public function all(Request $request){
        if($request->has('filter')):

            if($request->query('filter') == 'high-price'):
            
                $products = Product::orderBy('price','desc');
            elseif($request->query('filter') == 'low-price'):
            
                $products = Product::orderBy('price','asc');
            elseif($request->query('filter') == 'more-sales'):
            
                $products = Product::join('order_details','products.id','=','order_details.product_id')
                ->select('products.*',DB::Raw('sum(order_details.quantity) as order_quantity'))->groupby('products.id')->orderby('order_quantity','desc');
            
            elseif($request->query('filter') == 'less-sales'):
            
                $products = Product::join('order_details','products.id','=','order_details.product_id')
                ->select('products.*',DB::Raw('sum(order_details.quantity) as order_quantity'))->groupby('products.id')->orderby('order_quantity','asc');
                
            else:
            
                $products = Product::query();
            endif;
            return response()->json([
                'data_info'          => $products->paginate(10),
                'total_products'     => Product::count(),
                'active_products'    => Product::where('status',1)->count(),
                'finished_products'  => Product::where('quantity',0)->count(),
                'favourits'          => $request->user()->favourites()->pluck('product_id')->toArray()
            ]);
        else:
            return response()->json([
                'data_info'          => Product::paginate(10),
                'total_products'     => Product::count(),
                'active_products'    => $request->user()->products()->count(),
                'finished_products'  => $request->user()->products()->where('quantity',0)->count(),
                'favourits'          => $request->user()->favourites()->pluck('product_id')->toArray()
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
}
