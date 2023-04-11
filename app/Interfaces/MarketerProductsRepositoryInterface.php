<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
class MarketerProductsRepositoryInterface{
    public function all(Request $request){}

    public function search(Request $request){}

    public function show(Request $request , $id){}

    public function lowstock_products(Request $request){}

    public function take_screenshot_product(Request $request,$id){}

}
