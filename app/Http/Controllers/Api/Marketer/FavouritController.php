<?php

namespace App\Http\Controllers\Api\Marketer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\MarketerFavouritsRepositoryInterface;
class FavouritController extends Controller
{

    protected MarketerFavouritsRepositoryInterface $marketer_favourits;

    public function __construct(MarketerFavouritsRepositoryInterface $marketer_favourits){
        $this->marketer_favourits = $marketer_favourits;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return $this->marketer_favourits->all($request);
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

        return $this->marketer_favourits->save($request);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //
        return $this->marketer_favourits->delete($request,$id);
    }
}
