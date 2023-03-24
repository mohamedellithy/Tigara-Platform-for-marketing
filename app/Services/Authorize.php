<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
class Authorize{
    protected $guard = null;
    protected $ModelGuard = null;
    public function __construct(){
        $this->guard = \Config::get('app.Current_Domain_txt') ?: 'admin';
        $this->ModelGuard = "\App\Models\\".ucfirst($this->guard);
    }

    public function login(Request $request){
        if(Auth::guard($this->guard)->attempt(['phone' => $request->input('phone'), 'password' => $request->input('password'),'account_type' => \Config::get('app.Current_Domain') ])) {
            $user  = $this->ModelGuard::where('phone', $request->input('phone'))->firstOrFail();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'account_type' => $user->account_type
            ]);
        }
        else {
            $Check_Where_is_error = $this->ModelGuard::where([
                'phone' => $request->input('phone'),
                'account_type' => \Config::get('app.Current_Domain')
            ])->exists();
            if($Check_Where_is_error):
                return response()->json(['errors'=>[
                    "password" => [
                        "Password is not corrected please try again"
                    ]
                ]], 401);
            else:
                return response()->json(['errors'=>
                [
                    "phone" => [
                        "Phone Number is not exist please try again " 
                    ]
                ]], 401);
            endif;
        }
    }

    public function register(Request $request){
        $request['password']= Hash::make($request->input('password'));
        $request['remember_token'] = Str::random(10);
        $request['account_type']   = \Config::get('app.Current_Domain');
        $user = $this->ModelGuard::create($request->all());
        if(Auth::guard($this->guard)->attempt([
                'phone' => $request->input('phone'),
                'password' => $request->input('password_confirmation'),
                'account_type' => \Config::get('app.Current_Domain')
            ])) {
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'account_type' => $user->account_type
            ]);
        }
        else {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function logout($request){
        if(method_exists($request->user()->currentAccessToken(), 'delete')) {
            $request->user()->currentAccessToken()->delete();
        }

        auth()->guard($this->guard)->logout();
        return response()->json(['message' => 'You have been successfully logged out!'], 200);
    }
}
