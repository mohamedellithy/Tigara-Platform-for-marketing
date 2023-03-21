<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
class MarketerOrdersRepositoryInterface{
    public function all(Request $request){}

    public function save(Request $request){}

    public function show(Request $request,$id){}

    public function search(Request $request){}

    public function update(Request $request,$id){}

    public function delete(Request $request,$id){}
}