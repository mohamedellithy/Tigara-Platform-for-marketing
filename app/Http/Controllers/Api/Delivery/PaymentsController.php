<?php

namespace App\Http\Controllers\Api\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\DeliveryDueMadePaymentsRepositoryInterface;
class PaymentsController extends Controller
{
    //
     //
    protected DeliveryDueMadePaymentsRepositoryInterface $deliveryDueMadePayments;
    public function __construct(DeliveryDueMadePaymentsRepositoryInterface $deliveryDueMadePayments){
        $this->deliveryDueMadePayments = $deliveryDueMadePayments;
    }

    public function due_payments(Request $request){
        return $this->deliveryDueMadePayments->due_payments($request);
    }

    public function made_payments(Request $request){
        return $this->deliveryDueMadePayments->made_payments($request);
    }
}
