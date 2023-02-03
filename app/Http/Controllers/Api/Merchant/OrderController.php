<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\MerchantOrdersRepositoryInterface;
class OrderController extends Controller
{
    //
    protected MerchantOrdersRepositoryInterface $merchant_orders;
    public function __construct(MerchantOrdersRepositoryInterface $merchant_orders){
        $this->merchant_orders = $merchant_orders;
    }

    public function index(Request $request){
        return $this->merchant_orders->all($request);
    }

    public function search(Request $request){
        return $this->merchant_orders->search($request);
    }

    public function show(Request $request,$id){
        return $this->merchant_orders->show($request,$id);
    }
}
