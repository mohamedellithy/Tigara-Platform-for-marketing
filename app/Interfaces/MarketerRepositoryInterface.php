<?php
namespace App\Interfaces;

class MarketerRepositoryInterface{
    public function all(){}

    public function search($search = null){}

    public function save($data){}

    public function show($id){}

    public function update($data,$id){}

    public function bulk_update($data){}

    public function delete($id){}

    public function delete_items($data){}

    public function add_products_to_marketer($data,$id){}

    public function remove_products_from_marketer($data,$id){}

    public function marketer_products($id){}

    public function marketer_nothave_products($id){}
}