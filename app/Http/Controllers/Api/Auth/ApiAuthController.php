<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Services\Authorize;
use App\Http\Resources\User as UserResource;
class ApiAuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'sometimes|numeric|unique:users,phone'
        ]);

        return (new Authorize())->register($request);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'phone' => 'required|numeric',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()) {
            return response(['errors'=>$validator->errors()], 422);
        }

        return (new Authorize())->login($request);
    }

    public function me(Request $request){
        $user = $request->user();
        return response()->json(['user' => new UserResource($user)], 200);
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,'.$request->user()->id,
            'password' => 'sometimes|string|min:6|confirmed',
            'phone' => 'sometimes|numeric|unique:users,phone,'.$request->user()->id
        ]);

        if($request->has('password')):
            $request->merge([
                'password' => Hash::make($request->input('password'))
            ]);
        endif;

        $request->user()->update($request->all());

        return response()->json([
           'result' => 'تم تحديث البيانات بنجاح',
           'user' => new UserResource($request->user())
        ]);
    }

    public function logout(Request $request){
        // Revoke the token that was used to authenticate the current request...
        return (new Authorize())->logout($request);
    }

    public function regenerate_password(Request $request,$marketer_id){
        $new_password = Str::random(12);
        User::where('id',$marketer_id)->update([
           'password' => Hash::make($new_password)
        ]);
        
        return response()->json([
           'new_password' => $new_password
        ]);
    }
}
