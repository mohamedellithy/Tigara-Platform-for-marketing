<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
class MarketerProfitsRepositoryInterface{
    public function profits_all(){}

    public function search_profits($search = null){}

    public function payments_all(){}

    public function search_payments($search = null){}

    public function marketer_payments_update_type($data){}
}
