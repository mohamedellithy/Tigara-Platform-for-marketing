<?php
namespace App\Repositories;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\Attachments;
use App\Http\Resources\Product as ProductResource;
class ProductRepository extends ProductRepositoryInterface{

    public function all(Request $request){
       // return response()->json(['data' => $request->all()]);
        if($request->has('merchant_id')):
            return response()->json([
                'data_info'          => new ProductResource(Product::where('merchant_id',$request->query('merchant_id'))->with('merchant')->paginate(2)),
                'active_products'    => Product::where('status',1)->count(),
                'no_active_products' => Product::where('status',0)->count()
            ]);
        else:
            return response()->json([
                'data_info'          => new ProductResource(Product::with('merchant')->paginate(10)),
                'active_products'    => Product::where('status',1)->count(),
                'no_active_products' => Product::where('status',0)->count()
            ]);
        endif;
    }

    public function search(Request $request){
        if($request->has('merchant_id')):
            return response()->json([
                'data_info'          => ProductResource::collection(Product::with('merchant')->where('merchant_id',$request->query('merchant_id'))->where('name','Like','%'.$request->query('q').'%')->get()),
                'active_products'    => Product::where('merchant_id',$request->query('merchant_id'))->where('status',1)->where('name','Like','%'.$request->query('q').'%')->count(),
                'no_active_products' => Product::where('merchant_id',$request->query('merchant_id'))->where('status',0)->where('name','Like','%'.$request->query('q').'%')->count()
            ]);
        else:
            return response()->json([
                'data_info'          => ProductResource::collection(Product::with('merchant')->where('name','Like','%'.$request->query('q').'%')->get()),
                'active_products'    => Product::where('status',1)->where('name','Like','%'.$request->query('q').'%')->count(),
                'no_active_products' => Product::where('status',0)->where('name','Like','%'.$request->query('q').'%')->count()
            ]);
        endif;

    }

    public function save(Request $request){
        $data = $request->all();
        $add_new_product = Product::create([
            'name'          => $data['name'],
            'merchant_id'   => $data['merchant_id'],
            'merchant_commission'   => $data['merchant_commission'],
            'marketer_commission'   => $data['marketer_commission'],
            'price'         => $data['price'],
            'quantity'      => $data['quantity'] ?: 0,
            'description'   => $data['description'] ?: 1,
            'status'        => $data['status'] ?: 1
        ]);

        if($add_new_product):
            if($request->hasFile('thumbnail')):
                $attachments = new Attachments(
                    $add_new_product,
                    $request->file('thumbnail'),
                    'thumbnail'
                );
            endif;

            if($request->hasfile('attachments')):
                $attachments = new Attachments(
                    $add_new_product,
                    $request->file('attachments'),
                    'attachments'
                );
            endif;

            return response()->json([
                'result' => 'تم اضافة المنتج بنجاح'
            ]);
        endif;
    }

    public function show($id){
        return response()->json([
            'product'          => new ProductResource(Product::find($id))
        ]);
    }

    public function update(Request $request,$id){
        $data = $request->all();
        $product = Product::find($id);
        if($product):
            $update_new_product = $product->update($data);
            if($update_new_product):

                if($request->hasfile('thumbnail')):
                    $product->images()->where('image_type',0)->delete();
                    $attachments = new Attachments(
                        $product,
                        $request->file('thumbnail'),
                        'thumbnail'
                    );
                endif;

                if($request->hasfile('attachments')):
                    $product->images()->where('image_type',1)->delete();
                    $attachments = new Attachments(
                        $product,
                        $request->file('attachments'),
                        'attachments'
                    );
                endif;

                if($request->has('delete_media_ids')){
                    $product->images()->whereIn('id',$request->input('delete_media_ids'))->delete();
                }

                return response()->json([
                    'result' => 'تم تعديل المنتج بنجاح',
                    'ds'     => $request->has('delete_media_ids')
                ]);
            endif;
        endif;
    }

    public function bulk_update($data){
        
        $update_product = Product::whereIn('id',$data['ids'])->update([
            'status' => $data['update_status']
        ]);
    
        if($update_product):
            return response()->json([
                'result' => 'تم تعديل المنتج بنجاح'
            ]);
        endif;
    }

    public function delete($id){
        $product = Product::find($id);
        if($product):
            $delete_delivery = $product->delete();
            if($delete_delivery):
                return response()->json([
                    'result' => 'تم اضافة المنتج بنجاح'
                ]);
            endif;
        endif;
    }

    public function delete_items($data){
        if($data['type'] == 'all'):
            $remove_product = Product::truncate();
        else:
            $remove_product = Product::destroy($data['products']);
        endif;

        if($remove_product):
            return response()->json([
                'result' => 'تم حذف المنتج بنجاح'
            ]);
        endif;
    }
}
