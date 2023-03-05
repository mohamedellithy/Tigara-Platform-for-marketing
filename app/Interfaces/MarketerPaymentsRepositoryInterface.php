<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
class MarketerPaymentsRepositoryInterface{
    public function all(Request $request){}
    
    public function save(Request $request){}

    public function update(Request $request,$id){}
}