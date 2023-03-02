<?php

namespace App\Http\Controllers\Api\Marketer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\MarketerProductsRepositoryInterface;
class ProductController extends Controller
{
    protected MarketerProductsRepositoryInterface $marketer_products;
    public function __construct(MarketerProductsRepositoryInterface $marketer_products){
        $this->marketer_products = $marketer_products;
    }

    public function index(Request $request){
        return $this->marketer_products->all($request);
    }

    public function search(Request $request){
        return $this->marketer_products->search($request);
    }

    public function show(Request $request,$id){
        return $this->marketer_products->show($request,$id);
    }

    public function lowstock_products(Request $request){
        return $this->marketer_products->lowstock_products($request);
    }
}
