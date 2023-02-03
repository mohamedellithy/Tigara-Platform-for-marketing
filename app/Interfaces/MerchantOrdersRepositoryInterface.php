<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
class MerchantOrdersRepositoryInterface{
    public function all(Request $request){}

    public function search(Request $request){}

    public function show(Request $request , $id){}

}