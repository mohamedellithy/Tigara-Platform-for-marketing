<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
class MarketerCartRepositoryInterface{
    public function all(Request $request){}

    public function save(Request $request){}

    public function show($id){}

    public function update(Request $request,$id){}

    public function delete(Request $request,$id){}
}