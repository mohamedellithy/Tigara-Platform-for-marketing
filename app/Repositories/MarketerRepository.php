<?php
namespace App\Repositories;
use App\Interfaces\MarketerRepositoryInterface;
use App\Models\Marketer;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Marketer as MarketerResource;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class MarketerRepository extends MarketerRepositoryInterface{

    public function all(Request $request){
        if($request->has('marketer_profits')):
            $marketer = Marketer::whereHas('orders',function($query){
                $query->where('order_status',2);
            })->paginate(12);
        else:
            $marketer = Marketer::paginate(12);
        endif;

        $all_marketer_and_platform_orders_profits = Order::where('order_status',2)
            ->join('order_details','orders.id','=','order_details.order_id')
            ->join('products','order_details.product_id','=','products.id')
            ->select('orders.*','order_details.unit_price','order_details.quantity','products.merchant_commission')
            ->sum(DB::Raw('(order_details.unit_price - products.merchant_commission) * order_details.quantity'));

        $total_profites = Order::where('order_status',2)->sum('marketer_profit');

        return response()->json([
            'data_info'          => new MarketerResource($marketer),
            'all_marketers'      => Marketer::count(),
            'all_marketer_and_platform_orders_profits' => $all_marketer_and_platform_orders_profits,
            'total_profites'     => $total_profites,
            'total_platform_profits' => $all_marketer_and_platform_orders_profits - $total_profites
        ]);
    }

    public function search(Request $request){
        if($request->has('marketer_profits')):
            $marketer = Marketer::whereHas('orders',function($query){
                $query->where('order_status',2);
            })->where('name','Like','%'.$request->query('q').'%')->get();
        else:
            $marketer = Marketer::where('name','Like','%'.$request->query('q').'%')->get();
        endif;

        return response()->json([
            'data_info'          => MarketerResource::collection($marketer),
            'active_marketers'    => Marketer::where('status',1)->where('name','Like','%'.$request->query('q').'%')->count(),
            'no_active_marketers' => Marketer::where('status',0)->where('name','Like','%'.$request->query('q').'%')->count()
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
            'marketer'          => new MarketerResource(Marketer::with('products','orders_details')->find($id))
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
            $products = Product::where('private',1)->whereDoesntHave('marketers', function(Builder $query) use ($id){
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

            $products = Product::where('private',1)->whereHas('marketers', function(Builder $query) use ($id){
                $query->where('marketer_id', $id);
            });

            return response()->json([
                'result' =>  new ProductResource($products->paginate(10))
            ]);
        }
    }

    public function marketer_products($id){
        $products = Product::where('private',1)->whereHas('marketers', function(Builder $query) use ($id){
            $query->where('marketer_id', $id);
        });

        $no_active_products = Product::where('private',1)->whereDoesntHave('marketers', function(Builder $query) use ($id){
            $query->where('marketer_id', $id);
        });

        return response()->json([
            'data_info'           => new ProductResource($products->paginate(10)),
            'active_products'     => $products->count(),
            'no_active_products'  => $no_active_products->count()
        ]);
    }

    public function marketer_nothave_products($id){
        $products = Product::where('private',1)->whereDoesntHave('marketers', function(Builder $query) use ($id){
            $query->where('marketer_id', $id);
        });

        $no_active_products = Product::where('private',1)->whereHas('marketers', function(Builder $query) use ($id){
            $query->where('marketer_id', $id);
        });

        return response()->json([
            'data_info'           => new ProductResource($products->paginate(10)),
            'active_products'     => $no_active_products->count(),
            'no_active_products'  => $products->count()
        ]);
    }
}
