<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected ProductRepositoryInterface $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository){
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return $this->productRepository->all($request);
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
        return $this->productRepository->search($request);
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
            'name'        => ['required','string','max:255','unique:products,name'],
            'price'       => ['required','numeric'],
            'quantity'    => ['required','numeric'],
            'description' => ['required','string','min:255'],
            'thumbnail'   => ['required','image','mimes:png,jpg,gif,jpeg,svg'],
            'attachments.*'=> ['required','image','mimes:png,jpg,gif,jpeg,svg']
        ]);

        if($validate->fails()):
            return response()->json($validate->errors(),401);
        endif;

        return $this->productRepository->save($request);
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
        return $this->productRepository->show($id);
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
            'name'        => ['required','string','max:255','unique:products,name,'.$id],
            'price'       => ['required','numeric'],
            'quantity'    => ['required','numeric'],
            'description' => ['required','string','min:255'],
            'thumbnail'   => ['sometimes','image','mimes:png,jpg,gif,jpeg,svg'],
            'attachments.*'=> ['sometimes','image','mimes:png,jpg,gif,jpeg,svg']
        ]);

        if($validate->fails()):
            return response()->json($validate->errors(),403);
        endif;

        return $this->productRepository->update($request, $id);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $request
     * @return \Illuminate\Http\Response
     */
    public function bulk_update_status(Request $request){
        return $this->productRepository->bulk_update($request->all());
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
        return $this->productRepository->delete($id);
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
        return $this->productRepository->delete_items($request->all());
    }
}
