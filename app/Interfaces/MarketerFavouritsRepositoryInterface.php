<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
class MarketerFavouritsRepositoryInterface{
    public function all(Request $request){}

    public function search(Request $request){}

    public function save(Request $request){}

    public function delete(Request $request , $id){}

}
