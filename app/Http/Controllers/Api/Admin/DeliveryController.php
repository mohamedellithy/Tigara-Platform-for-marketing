<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\DeliveryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends Controller
{
    protected DeliveryRepositoryInterface $deliveryRepository;
    public function __construct(DeliveryRepositoryInterface $deliveryRepository){
        $this->deliveryRepository  = $deliveryRepository;
     }
   
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return $this->deliveryRepository->all($request);
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
        return $this->deliveryRepository->search($request);
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
            'name'     => ['required','string','max:255'],
            'email'    => ['required','string','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8','confirmed']
        ]);

        if($validate->fails()):
            return response()->json($validate->errors(),401);
        endif;

        return $this->deliveryRepository->save($request->all());
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
        return $this->deliveryRepository->show($id);
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
        $validate = Validator::make($request->all(),[
            'name'     => ['sometimes','string','max:255'],
            'email'    => ['sometimes','string','email','max:255','unique:users,email,'.$id],
            'password' => ['sometimes','string','min:8','confirmed']
        ]);

        if($validate->fails()):
            return response()->json($validate->errors(),401);
        endif;

        return $this->deliveryRepository->update($request->all(),$id);
    }

    public function bulk_update_status(Request $request){
        return $this->deliveryRepository->bulk_update($request->all());
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
        return $this->deliveryRepository->delete($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function truncate(Request $request)
    {
        //
        return $this->deliveryRepository->delete_items($request->all());
    }
}
