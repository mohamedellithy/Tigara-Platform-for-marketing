<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\MerchantProductsRepositoryInterface;
class ProductController extends Controller
{
    //
    protected MerchantProductsRepositoryInterface $merchant_products;
    public function __construct(MerchantProductsRepositoryInterface $merchant_products){
        $this->merchant_products = $merchant_products;
    }

    public function index(Request $request){
        return $this->merchant_products->all($request);
    }

    public function search(Request $request){
        return $this->merchant_products->search($request);
    }

    public function show(Request $request,$id){
        return $this->merchant_products->show($request,$id);
    }

    public function lowstock_products(Request $request){
        return $this->merchant_products->lowstock_products($request);
    }
}
