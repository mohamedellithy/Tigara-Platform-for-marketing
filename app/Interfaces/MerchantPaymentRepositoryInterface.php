<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
class MerchantPaymentRepositoryInterface{
    public function all(Request $request){}

    public function search($search = null){}

    public function save($data){}

    // public function show($id){}

    public function update($data,$id){}

    // public function bulk_update($data){}

    public function delete($id){}

    // public function delete_items($data){}
}
