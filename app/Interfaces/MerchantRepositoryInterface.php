<?php
namespace App\Interfaces;

class MerchantRepositoryInterface{
    public function all(){}

    public function search($search = null){}

    public function save($data){}

    public function show($id){}

    public function update($data,$id){}

    public function bulk_update($data){}

    public function delete($id){}

    public function delete_items($data){}
}