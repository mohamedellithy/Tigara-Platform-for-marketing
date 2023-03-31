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

                $products = Product::whereHas('marketers',function($query) use($request){
                    $query->where('product_marketers.marketer_id',$request->user()->id);
                })->orWhere('private',0)->orderBy('price','desc');
            
            elseif($request->query('filter') == 'low-price'):

                $products = Product::whereHas('marketers',function($query) use($request){
                    $query->where('product_marketers.marketer_id',$request->user()->id);
                })->orWhere('private',0)->orderBy('price','asc');
            
            elseif($request->query('filter') == 'more-sales'):
                DB::statement("SET SQL_MODE=''");
                $products = Product::whereHas('marketers',function($query) use($request){
                    $query->where('product_marketers.marketer_id',$request->user()->id);
                })->orWhere('private',0)->join('order_details','products.id','=','order_details.product_id')
                ->select('products.*',DB::Raw('sum(order_details.quantity) as order_quantity'))->groupBy('products.id')->orderby('order_quantity','desc');
            
            elseif($request->query('filter') == 'less-sales'):
                DB::statement("SET SQL_MODE=''");
                $products = Product::whereHas('marketers',function($query) use($request){
                    $query->where('product_marketers.marketer_id',$request->user()->id);
                })->orWhere('private',0)->join('order_details','products.id','=','order_details.product_id')
                ->select('products.*',DB::Raw('sum(order_details.quantity) as order_quantity'))->groupBy('products.id')->orderby('order_quantity','asc');
            
            elseif($request->query('filter') == 'low-stock'):
                DB::statement("SET SQL_MODE=''");
                $products = Product::whereHas('marketers',function($query) use($request){
                    $query->where('product_marketers.marketer_id',$request->user()->id);
                })->orWhere('private',0)->join('carts','products.id','=','carts.product_id')
                ->select('products.*',DB::Raw('sum(carts.quantity) as cart_quantity'))->groupBy('products.id')->havingRaw('IF(products.quantity >= cart_quantity,products.quantity - cart_quantity,products.quantity) = 0');
                //DB::Raw('sum(carts.quantity) as carts.carts_qty')

            elseif($request->query('filter') == 'about-to-low'):
                DB::statement("SET SQL_MODE=''");
                $products = Product::whereHas('marketers',function($query) use($request){
                    $query->where('product_marketers.marketer_id',$request->user()->id);
                })->orWhere('private',0)->join('carts','products.id','=','carts.product_id')
                ->select('products.*',DB::Raw('sum(carts.quantity) as cart_quantity'))->groupBy('products.id')
                ->havingRaw('(IF(products.quantity >= cart_quantity,products.quantity - cart_quantity,products.quantity) < 8) AND (IF(products.quantity >= cart_quantity,products.quantity - cart_quantity,products.quantity) > 0 )');
            else:

                $products = Product::query();
            endif;
            return response()->json([
                'data_info'          => $products->paginate(10),
                'total_products'     => Product::whereHas('marketers',function($query) use($request){
                    $query->where('product_marketers.marketer_id',$request->user()->id);
                })->orWhere('private',0)->count(),
                'active_products'    => Product::whereHas('marketers',function($query) use($request){
                    $query->where('product_marketers.marketer_id',$request->user()->id);
                })->orWhere('private',0)->where('status',1)->count(),
                'finished_products'  => Product::whereHas('marketers',function($query) use($request){
                    $query->where('product_marketers.marketer_id',$request->user()->id);
                })->orWhere('private',0)->where('quantity',0)->count(),
                'favourits'          => $request->user()->favourites()->pluck('product_id')->toArray()
            ]);
        else:
            return response()->json([
                'data_info'          => Product::whereHas('marketers',function($query) use($request){
                    $query->where('product_marketers.marketer_id',$request->user()->id);
                })->orWhere('private',0)->paginate(10),
                'total_products'     => Product::whereHas('marketers',function($query) use($request){
                    $query->where('product_marketers.marketer_id',$request->user()->id);
                })->orWhere('private',0)->count(),
                'active_products'    => $request->user()->products()->count(),
                'finished_products'  => $request->user()->products()->where('quantity',0)->count(),
                'favourits'          => $request->user()->favourites()->pluck('product_id')->toArray()
            ]);
        endif;
    }

    public function search(Request $request){
        return response()->json([
            'data_info'          => Product::whereHas('marketers',function($query) use($request){
                $query->where('product_marketers.marketer_id',$request->user()->id);
            })->orWhere('private',0)->where('name','Like','%'.$request->query('q').'%')->get(),
        ]);

    }

    public function show(Request $request,$id){
        return response()->json([
            'product'          => Product::find($id)
        ]);
    }

    public function lowstock_products(Request $request){
        return response()->json([
            'data_info'  => $request->user()->products()->where('quantity',0)->paginate(5),
            'finished_products' => $request->user()->products()->where('quantity',0)->count()
        ]);
    }
}
