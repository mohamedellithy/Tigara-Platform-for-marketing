<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
class MerchantProductsRepositoryInterface{
    public function all(Request $request){}

    public function search(Request $request){}

    public function show(Request $request , $id){}

    public function lowstock_products(Request $request){}

    public function about_to_out_products(Request $request){}

}