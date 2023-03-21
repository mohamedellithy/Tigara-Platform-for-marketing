<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
class MerchantRepositoryInterface{
    public function all(Request $request){}

    public function search(Request $request){}

    public function save($data){}

    public function show($id){}

    public function update($data,$id){}

    public function bulk_update($data){}

    public function delete($id){}

    public function delete_items($data){}
}