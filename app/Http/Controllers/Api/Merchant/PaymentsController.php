<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\MerchantDueMadePaymentsRepositoryInterface;

class PaymentsController extends Controller
{
    //
    protected MerchantDueMadePaymentsRepositoryInterface $merchantDueMadePayments;
    public function __construct(MerchantDueMadePaymentsRepositoryInterface $merchantDueMadePayments){
        $this->merchantDueMadePayments = $merchantDueMadePayments;
    }

    public function due_payments(Request $request){
        return $this->merchantDueMadePayments->due_payments($request);
    }

    public function made_payments(Request $request){
        return $this->merchantDueMadePayments->made_payments($request);
    }
}
