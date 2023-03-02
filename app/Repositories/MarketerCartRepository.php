<?php
namespace App\Repositories;
use App\Interfaces\MarketerCartRepositoryInterface;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Resources\Cart as CartResource;
class MarketerCartRepository extends MarketerCartRepositoryInterface{

    public function all(Request $request){
        return response()->json([
            'cart_items' => CartResource::collection($request->user()->carts)
        ]);
    }

    public function save(Request $request){
        $cart = $request->user()->carts()->where('product_id',$request->input('product_id'))->exists();
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

    public function show($id){}

    public function update(Request $request,$id){
        if($request->input('type') == 'plus'){
        
            $request->user()->carts()->where('id',$id)->increment('quantity',1);
        
        } else if($request->input('type') == 'minus'){
        
            $request->user()->carts()->where('id',$id)->decrement('quantity',1);
        }

        return response()->json([
            'total_quantity' => $request->user()->total_cart_items,
            'cart_items' => CartResource::collection($request->user()->carts)
        ]);
    }

    public function delete(Request $request,$id){
        $request->user()->carts()->where('id',$id)->delete();
        return response()->json([
            'data' => $request->user()->carts,
            'total_quantity' => $request->user()->total_cart_items,
            'cart_items' => CartResource::collection($request->user()->carts)
        ]);
    }
}
