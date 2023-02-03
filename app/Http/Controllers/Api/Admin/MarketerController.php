<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\MarketerRepositoryInterface;
class MarketerController extends Controller
{

    protected MarketerRepositoryInterface $marketerRepository;
    public function __construct(MarketerRepositoryInterface $marketerRepository){
        $this->marketerRepository  = $marketerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->marketerRepository->all();
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
        return $this->marketerRepository->show($id);
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

        return $this->marketerRepository->delete($id);
    }

    public function bulk_update_status(Request $request){
        return $this->marketerRepository->bulk_update($request->all());
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
        return $this->marketerRepository->delete_items($request->all());
    }

    public function add_products_to_marketer(Request $request,$id){
        return $this->marketerRepository->add_products_to_marketer($request->all(),$id);
    }

    public function remove_products_from_marketer(Request $request,$id){
       return $this->marketerRepository->remove_products_from_marketer($request->all(),$id);
    }

    public function marketer_products($id){
        return $this->marketerRepository->marketer_products($id);
    }

    public function marketer_nothave_products($id){
        return $this->marketerRepository->marketer_nothave_products($id);
    }
}
