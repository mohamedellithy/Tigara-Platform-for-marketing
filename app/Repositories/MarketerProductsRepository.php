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
use Spatie\Browsershot\Browsershot;
class MarketerProductsRepository extends MarketerProductsRepositoryInterface{

    public function all(Request $request){
        if($request->has('filter')):
            if($request->query('filter') == 'high-price'):

                $products = Product::WithMarketerProducts($request->user()->id)->orderBy('price','desc');
            elseif($request->query('filter') == 'low-price'):

                $products = Product::WithMarketerProducts($request->user()->id)->orderBy('price','asc');
            elseif($request->query('filter') == 'more-sales'):

                DB::statement("SET SQL_MODE=''");
                $products = Product::WithMarketerProducts($request->user()->id)->MoreSales();
            elseif($request->query('filter') == 'less-sales'):

                DB::statement("SET SQL_MODE=''");
                $products = Product::WithMarketerProducts($request->user()->id)->LessSales();
            elseif($request->query('filter') == 'low-stock'):

                DB::statement("SET SQL_MODE=''");
                $products = Product::WithMarketerProducts($request->user()->id)->LowStock();
                //DB::Raw('sum(carts.quantity) as carts.carts_qty')
            elseif($request->query('filter') == 'about-to-low'):

                DB::statement("SET SQL_MODE=''");
                $products = Product::WithMarketerProducts($request->user()->id)->AboutToLow();
            else:

                $products = Product::query();
            endif;
            return response()->json([
                'data_info'          => $products->paginate(10),
                'total_products'     => Product::WithMarketerProducts($request->user()->id)->count(),
                'active_products'    => Product::WithMarketerProducts($request->user()->id)->where('status',1)->count(),
                'finished_products'  => Product::WithMarketerProducts($request->user()->id)->where('quantity',0)->count(),
                'favourits'          => $request->user()->favourites()->pluck('product_id')->toArray()
            ]);
        else:
            return response()->json([
                'data_info'          => Product::WithMarketerProducts($request->user()->id)->paginate(10),
                'total_products'     => Product::WithMarketerProducts($request->user()->id)->count(),
                'active_products'    => $request->user()->products()->count(),
                'finished_products'  => $request->user()->products()->where('quantity',0)->count(),
                'favourits'          => $request->user()->favourites()->pluck('product_id')->toArray()
            ]);
        endif;
    }

    public function search(Request $request){
        return response()->json([
            'data_info'          => Product::WithMarketerProducts($request->user()->id)->where('name','Like','%'.$request->query('q').'%')->get(),
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

    public function take_screenshot_product(Request $request,$id){
        $path = storage_path('app/public/screenshots/screen'.$id.$request->user()->id.'shot.png');
        Browsershot::url('http://marketer.tigara.demo/take-a-screenshot/'.$id)
        ->setOption('args', ['--disable-web-security'])->waitUntilNetworkIdle()->emulateMedia(null)
        ->fullPage()->windowSize(500,800)->setExtraHttpHeaders(['Authorization' => 'Bearer ' . $request->bearerToken() ])
        ->showBackground()->save($path);
        return response()->json([
           'screenshot_url' =>  asset('storage/screenshots/screen'.$id.$request->user()->id.'shot.png')
        ]);
    }
}
