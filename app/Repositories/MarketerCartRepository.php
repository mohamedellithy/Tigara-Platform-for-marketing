<?php
namespace App\Repositories;
use App\Interfaces\MarketerCartRepositoryInterface;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Resources\Cart as CartResource;
use App\Services\StockService;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
class MarketerCartRepository extends MarketerCartRepositoryInterface{

    public function all(Request $request){
        return response()->json([
            'cart_items'             => CartResource::collection($request->user()->carts),
            'total_marketer_profits' => $request->user()->carts()->join('products','carts.product_id','=','products.id')
                                        ->select('carts.*','products.merchant_commission as merchant_commission','products.marketer_commission as marketer_commission')
                                        ->sum(DB::Raw('carts.quantity * ( ((carts.price - merchant_commission)  * marketer_commission ) / 100)')),
            'total_cart_cost'        => $request->user()->carts()->sum(DB::Raw('quantity * price')),
            'total_cart_items'       => $request->user()->carts()->sum('quantity'),
            'total_products'         => $request->user()->carts()->count()
        ]);
    }

    public function save(Request $request){
        $cart = $request->user()->carts()->where('product_id',$request->input('product_id'))->exists();
        
        // check stock availability
        $stock = new StockService(
            Product::find($request->input('product_id'))
        );

        // set quantity
        $stock->required_quantity = $request->input('quantity');

        // is stock is not available
        if($stock->stock_availaibility() == false):
            return response()->json([
                'status'         => 'كمية المحددة غير متاحة للمنتج',
                'data'           => $request->user()->carts,
                'total_quantity' => $request->user()->total_cart_items,
                'cart_items'     => CartResource::collection($request->user()->carts)
            ]);
        endif;

        if($cart){
            $insertCart = $request->user()->carts()->where('product_id',$request->input('product_id'))->increment('quantity',$request->input('quantity'));
        } else {
            $insertCart = $request->user()->carts()->Create([
                'product_id' => $request->input('product_id'),
                'quantity'   => $request->input('quantity'),
                'price'      => $request->input('price')
            ]);
        }
        
        return response()->json([
            'data' => $request->user()->carts,
            'total_quantity' => $request->user()->total_cart_items,
            'cart_items' => CartResource::collection($request->user()->carts)
        ]);
    }

    public function update(Request $request,$id){

        $item_in_cart = $request->user()->carts()->where('id',$id);

        if($request->input('type') == 'plus'){

            // check stock
            $stock = new StockService(
                Product::find($item_in_cart->first()->product_id),
            );

            // set quantity
            $stock->required_quantity = 1;

            // is stock is not available
            if($stock->stock_availaibility() == false):
                return response()->json([
                    'status'         => 'كمية المحددة غير متاحة للمنتج',
                    'total_quantity' => $request->user()->total_cart_items,
                    'cart_items' => CartResource::collection($request->user()->carts),
                    'total_marketer_profits' => $request->user()->carts()->join('products','carts.product_id','=','products.id')
                        ->select('carts.*','products.merchant_commission as merchant_commission','products.marketer_commission as marketer_commission')
                        ->sum(DB::Raw('carts.quantity * ( ((carts.price - merchant_commission)  * marketer_commission ) / 100)')),
                    'total_cart_cost'        => $request->user()->carts()->sum(DB::Raw('quantity * price')),
                    'total_cart_items'       => $request->user()->carts()->sum('quantity'),
                    'total_products'         => $request->user()->carts()->count()
                ]);
            endif;

            $item_in_cart->increment('quantity',1);
        
        } else if($request->input('type') == 'minus'){
        
            $item_in_cart->decrement('quantity',1);
        }

        return response()->json([
            'total_quantity' => $request->user()->total_cart_items,
            'cart_items' => CartResource::collection($request->user()->carts),
            'total_marketer_profits' => $request->user()->carts()->join('products','carts.product_id','=','products.id')
                        ->select('carts.*','products.merchant_commission as merchant_commission','products.marketer_commission as marketer_commission')
                        ->sum(DB::Raw('carts.quantity * ( ((carts.price - merchant_commission)  * marketer_commission ) / 100)')),
            'total_cart_cost'        => $request->user()->carts()->sum(DB::Raw('quantity * price')),
            'total_cart_items'       => $request->user()->carts()->sum('quantity'),
            'total_products'         => $request->user()->carts()->count()
        ]);
    }

    public function delete(Request $request,$id){
        $request->user()->carts()->where('id',$id)->delete();
        return response()->json([
            'data' => $request->user()->carts,
            'total_quantity' => $request->user()->total_cart_items,
            'cart_items' => CartResource::collection($request->user()->carts),
            'total_marketer_profits' => $request->user()->carts()->join('products','carts.product_id','=','products.id')
                        ->select('carts.*','products.merchant_commission as merchant_commission','products.marketer_commission as marketer_commission')
                        ->sum(DB::Raw('carts.quantity * ( ((carts.price - merchant_commission)  * marketer_commission ) / 100)')),
            'total_cart_cost'        => $request->user()->carts()->sum(DB::Raw('quantity * price')),
            'total_cart_items'       => $request->user()->carts()->sum('quantity'),
            'total_products'         => $request->user()->carts()->count()
        ]);
    }
}
