<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
class DeliveryPaymentRepositoryInterface{
    public function all(Request $request){}

    public function search($search = null){}

    public function save($data){}

    public function update($data,$id){}

    public function delete($id){}

}
