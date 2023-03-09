<?php
namespace App\Repositories;
use App\Interfaces\MerchantRepositoryInterface;
use App\Models\Merchant;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Merchant as MerchantResource;
use App\Http\Resources\MerchantCollections as MerchantCollectionsResource;
class MerchantRepository extends MerchantRepositoryInterface{

    public function all(){
       // return response()->json(['data' => $request->all()]);
        return response()->json([
            'data_info'          => new MerchantCollectionsResource(Merchant::paginate(12)),
            'all_merchants'      => Merchant::count(),
            'active_merchant'    => Merchant::where('status',1)->count(),
            'no_active_merchant' => Merchant::where('status',0)->count()
        ]);
    }

    public function search($search = null){
        return response()->json([
            'data_info'          => MerchantResource::collection(Merchant::where('name','Like','%'.$search.'%')->get()),
            'all_merchants'      => Merchant::count(),
            'active_merchant'    => Merchant::where('status',1)->where('name','Like','%'.$search.'%')->count(),
            'no_active_merchant' => Merchant::where('status',0)->where('name','Like','%'.$search.'%')->count()
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
