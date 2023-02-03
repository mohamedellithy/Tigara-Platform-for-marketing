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
class ApiAuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        return (new Authorize())->register($request);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()) {
            return response(['errors'=>$validator->errors()], 422);
        }

        return (new Authorize())->login($request);
    }

    public function me(Request $request){
        $user = $request->user();
        return response()->json(['user' => $user], 200);
    }

    public function logout(Request $request){
        // Revoke the token that was used to authenticate the current request...
        return (new Authorize())->logout($request);
    }
}
