<?php

namespace App\Http\Controllers\Api\Marketer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\MarketerPaymentsRepositoryInterface;
class PaymentsController extends Controller
{
    protected MarketerPaymentsRepositoryInterface $marketer_payments;
    public function __construct(MarketerPaymentsRepositoryInterface $marketer_payments){
            $this->marketer_payments = $marketer_payments;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return $this->marketer_payments->all($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return $this->marketer_payments->save($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        return $this->marketer_payments->update($request, $id);
    }
}
