<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
class DeliveryDueMadePaymentsRepositoryInterface{
    public function due_payments(Request $request){}

    public function made_payments(Request $request){}
}