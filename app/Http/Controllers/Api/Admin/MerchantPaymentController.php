<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\MerchantPayment;
use App\Interfaces\MerchantPaymentRepositoryInterface;
use Illuminate\Support\Facades\Validator;
class MerchantPaymentController extends Controller
{
    protected MerchantPaymentRepositoryInterface $merchantPaymentRepository;
    public function __construct(MerchantPaymentRepositoryInterface $merchantPaymentRepository){
        $this->merchantPaymentRepository = $merchantPaymentRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return $this->merchantPaymentRepository->all($request);
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
        return $this->merchantPaymentRepository->search($request->query('q'));
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
        $validate = Validator::make($request->all(),[
            'merchant_id' => ['required','exists:users,id'],
            'type'        => ['required','numeric'],
            'value'       => ['required','numeric']
        ]);

        if ($validate->fails()):
            return response()->json($validate->errors(),401);
        endif;

        return $this->merchantPaymentRepository->save($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return $this->merchantPaymentRepository->show($id);
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
        return $this->merchantPaymentRepository->update($request->all(), $id);
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
        return $this->merchantPaymentRepository->delete($id);
    }
}
