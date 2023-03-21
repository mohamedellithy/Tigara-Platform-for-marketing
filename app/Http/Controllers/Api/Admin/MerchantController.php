<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\MerchantRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class MerchantController extends Controller
{
    private MerchantRepositoryInterface $merchantRepository;

     /**
     * Register Interface Repository
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(MerchantRepositoryInterface $merchantRepository)
    {
        $this->merchantRepository = $merchantRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return $this->merchantRepository->all($request);
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
        return $this->merchantRepository->search($request);
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

        return $this->merchantRepository->save($request->all());
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
        return $this->merchantRepository->show($id);
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

        return $this->merchantRepository->update($request->all(),$id);
    }

    public function bulk_update_status(Request $request){
        return $this->merchantRepository->bulk_update($request->all());
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
        return $this->merchantRepository->delete($id);
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
        return $this->merchantRepository->delete_items($request->all());
    }
}
