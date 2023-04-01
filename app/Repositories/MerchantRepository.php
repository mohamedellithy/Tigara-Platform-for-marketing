<?php
namespace App\Repositories;
use App\Interfaces\MerchantRepositoryInterface;
use App\Models\Merchant;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Merchant as MerchantResource;
use App\Http\Resources\MerchantCollections as MerchantCollectionsResource;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MerchantRepository extends MerchantRepositoryInterface{

    public function all(Request $request){
       // return response()->json(['data' => $request->all()]);
        if($request->has('merchant_profits')):
            $merchant = Merchant::whereHas('order_details.order',function($query){
                $query->where('order_status',2);
            })->paginate(12);
        else:
            $merchant = Merchant::paginate(12);
        endif;
        $total_merchant_products_sales = OrderDetails::whereHas('order',function($query){
            $query->where('order_status',2);
        })->join('products','products.id','=','order_details.product_id')->select('products.merchant_commission','order_details.*')
        ->sum(DB::Raw('products.merchant_commission * order_details.quantity'));

        $total_sales = OrderDetails::whereHas('order',function($query){
            $query->where('order_status',2);
        })->sum(DB::Raw('order_details.unit_price * order_details.quantity'));


        return response()->json([
            'data_info'                        => new MerchantCollectionsResource($merchant),
            'all_merchants'                    => Merchant::count(),
            'total_merchant_products_sales'    => $total_merchant_products_sales,
            'total_sales'                      => $total_sales,
            'total_platform_profits'           => $total_sales - $total_merchant_products_sales
        ]);
    }

    public function search(Request $request){
        if($request->has('merchant_profits')):
            $merchant = Merchant::whereHas('order_details.order',function($query){
                $query->where('order_status',2);
            })->where('name','Like','%'.$request->query('q').'%')->get();
        else:
            $merchant = Merchant::where('name','Like','%'.$request->query('q').'%')->get();
        endif;
        return response()->json([
            'data_info'          => MerchantResource::collection($merchant),
            'all_merchants'      => Merchant::count(),
            'active_merchant'    => Merchant::where('status',1)->where('name','Like','%'.$request->query('q').'%')->count(),
            'no_active_merchant' => Merchant::where('status',0)->where('name','Like','%'.$request->query('q').'%')->count()
        ]);

    }

    public function save($data){
        $add_new_merchant = Merchant::create([
            'name'          => $data['name'],
            'phone'         => $data['phone'],
            'store_name'    => $data['store_name'],
            'email'         => $data['email'],
            'status'        => $data['status'],
            'account_type'  => 1,
            'password'      => Hash::make($data['password']),
        ]);

        if($add_new_merchant):
            return response()->json([
                'result' => 'تم انشاء حساب تاجر بنجاح'
            ]);
        endif;
    }

    public function show($id){
        return response()->json([
            'merchant'          => new MerchantResource(Merchant::with('products')->find($id))
        ]);
    }

    public function update($data,$id){
        $merchant = Merchant::find($id);
        if($merchant):

            if(isset($data['password'])):
                $data['password'] = Hash::make($data['password']);
            endif;

            $add_new_merchant = $merchant->update($data);

            if($add_new_merchant):
                return response()->json([
                    'result' => 'تم تعديل حساب تاجر بنجاح'
                ]);
            endif;
        endif;
    }

    public function bulk_update($data){

        $update_merchant = Merchant::whereIn('id',$data['ids'])->update([
            'status' => $data['update_status']
        ]);

        if($update_merchant):
            return response()->json([
                'result' => 'تم تعديل  بنجاح'
            ]);
        endif;
    }

    public function delete($id){
        $merchant = Merchant::find($id);
        if($merchant):
            $delete_merchant = $merchant->delete();
            if($delete_merchant):
                return response()->json([
                    'result' => 'تم حذف حساب تاجر بنجاح'
                ]);
            endif;
        endif;
    }

    public function delete_items($data){
        if($data['type'] == 'all'):
            $remove_merchant = Merchant::truncate();
        else:
            $remove_merchant = Merchant::destroy($data['merchants']);
        endif;

        if($remove_merchant):
            return response()->json([
                'result' => 'تم حذف بنجاح'
            ]);
        endif;
    }
}
