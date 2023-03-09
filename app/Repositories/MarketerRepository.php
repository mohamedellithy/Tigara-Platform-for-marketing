<?php
namespace App\Repositories;
use App\Interfaces\MarketerRepositoryInterface;
use App\Models\Marketer;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Marketer as MarketerResource;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Database\Eloquent\Builder;

class MarketerRepository extends MarketerRepositoryInterface{

    public function all(){
       // return response()->json(['data' => $request->all()]);
        return response()->json([
            'data_info'           => new MarketerResource(Marketer::paginate(15)),
            'all_marketers'       => Marketer::count(),
            'active_marketer'    => Marketer::where('status',1)->count(),
            'no_active_marketer' => Marketer::where('status',0)->count()
        ]);
    }

    public function search($search = null){
        return response()->json([
            'data_info'          => MarketerResource::collection(Marketer::where('name','Like','%'.$search.'%')->get()),
            'active_marketers'    => Marketer::where('status',1)->where('name','Like','%'.$search.'%')->count(),
            'no_active_marketers' => Marketer::where('status',0)->where('name','Like','%'.$search.'%')->count()
        ]);

    }

    public function save($data){
        $add_new_marketer = Marketer::create([
            'name'          => $data['name'],
            'phone'         => $data['phone'],
            'email'         => $data['email'],
            'account_type'  => $data['account_type'] ?: 2,
            'status'        => $data['status'] ?: 1,
            'password'      => Hash::make($data['password']),
        ]);

        if($add_new_marketer):
            return response()->json([
                'result' => 'تم انشاء حساب مسوق بنجاح'
            ]);
        endif;
    }

    public function show($id){
        return response()->json([
            'marketer'          => new MarketerResource(Marketer::with('products')->find($id))
        ]);
    }

    public function update($data,$id){
        $marketer = Marketer::find($id);
        if($marketer):

            if(isset($data['password'])):
                $data['password'] = Hash::make($data['password']);
            endif;

            $add_new_market = $marketer->update($data);
       
            if($add_new_market):
                return response()->json([
                    'result' => 'تم تعديل حساب تاجر بنجاح'
                ]);
            endif;
        endif;
    }

    public function bulk_update($data){
        
        $update_marketer = Marketer::whereIn('id',$data['ids'])->update([
            'status' => $data['update_status']
        ]);
    
        if($update_marketer):
            return response()->json([
                'result' => 'تم تعديل  بنجاح'
            ]);
        endif;
    }

    public function delete($id){
        $marketer = Marketer::find($id);
        if($marketer):
            $delete_marketer = $marketer->delete();
            if($delete_marketer):
                return response()->json([
                    'result' => 'تم حذف حساب مسوق بنجاح'
                ]);
            endif;
        endif;
    }

    public function delete_items($data){
        if($data['type'] == 'all'):
            $remove_marketer = marketer::truncate();
        else:
            $remove_marketer = marketer::destroy($data['marketers']);
        endif;

        if($remove_marketer):
            return response()->json([
                'result' => 'تم حذف بنجاح'
            ]);
        endif;
    }

    public function add_products_to_marketer($data,$id){
        $merketer = Marketer::find($id);
        $handle_products_ids = $data['products'];
        if(count($data['products']) > 0){
            $product_ids = $merketer->products()->pluck('product_id')->toArray();
            if (count($product_ids) > 0):
                $handle_products_ids = array_diff($data['products'],$product_ids);
            endif;

            $merketer->products()->attach($handle_products_ids,['status'=>1]);
            $products = Product::whereDoesntHave('marketers', function(Builder $query) use ($id){
                $query->where('marketer_id', $id);
            });

            return response()->json([
                'result' => new ProductResource($products->paginate(10))
            ]);
        }
    }

    public function remove_products_from_marketer($data,$id){
        $merketer = Marketer::find($id);
        if(count($data['products']) > 0){
            $merketer->products()->detach($data['products'],['status'=>1]);
            
            $products = Product::whereHas('marketers', function(Builder $query) use ($id){
                $query->where('marketer_id', $id);
            });

            return response()->json([
                'result' =>  new ProductResource($products->paginate(10))
            ]);
        }
    }

    public function marketer_products($id){
        $products = Product::whereHas('marketers', function(Builder $query) use ($id){
            $query->where('marketer_id', $id);
        });

        $no_active_products = Product::whereDoesntHave('marketers', function(Builder $query) use ($id){
            $query->where('marketer_id', $id);
        });

        return response()->json([
            'data_info'           => new ProductResource($products->paginate(10)),
            'active_products'     => $products->count(),
            'no_active_products'  => $no_active_products->count()
        ]);
    }

    public function marketer_nothave_products($id){
        $products = Product::whereDoesntHave('marketers', function(Builder $query) use ($id){
            $query->where('marketer_id', $id);
        });

        $no_active_products = Product::whereHas('marketers', function(Builder $query) use ($id){
            $query->where('marketer_id', $id);
        });

        return response()->json([
            'data_info'           => new ProductResource($products->paginate(10)),
            'active_products'     => $no_active_products->count(),
            'no_active_products'  => $products->count()
        ]);
    }
}
