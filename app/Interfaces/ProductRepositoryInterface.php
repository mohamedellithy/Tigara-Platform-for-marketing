<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
class ProductRepositoryInterface{
    public function all(Request $request){}

    public function search(Request $request){}

    public function save(Request $request){}

    public function show($id){}

    public function update(Request $request,$id){}

    public function bulk_update($data){}

    public function delete($id){}

    public function delete_items($data){}
}