<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
class DeliveryOrdersRepositoryInterface{
    public function all(Request $request){}

    public function search(Request $request){}

     public function update($data,$id){}

    public function bulk_update_status($data){}

    public function show(Request $request , $id){}

}