<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\DeliveryPayment;
use App\Interfaces\DeliveryPaymentRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class DeliveryPaymentController extends Controller
{

    protected DeliveryPaymentRepositoryInterface $deliveryPaymentRepository;
    public function __construct(DeliveryPaymentRepositoryInterface $deliveryPaymentRepository){
        $this->deliveryPaymentRepository = $deliveryPaymentRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return $this->deliveryPaymentRepository->all($request);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //
        //return response()->json(['data' => $request->query('q')]);
        return $this->deliveryPaymentRepository->search($request->query('q'));
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
        dd($request->all());
        $validate = Validator::make($request->all(),[
            'delivery_id' => ['required','exists:users,id'],
            'type'        => ['required','numeric'],
            'value'       => ['required','numeric','gt:0']
        ]);

        if ($validate->fails()):
            return response()->json($validate->errors(),401);
        endif;

        return $this->deliveryPaymentRepository->save($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    //     return $this->deliveryPaymentRepository->show($id);
    // }

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
        return $this->deliveryPaymentRepository->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return $this->deliveryPaymentRepository->delete($id);
    }
}
