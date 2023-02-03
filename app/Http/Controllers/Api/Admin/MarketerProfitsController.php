<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\MarketerProfitsRepositoryInterface;
use Illuminate\Http\Request;

class MarketerProfitsController extends Controller
{
    protected MarketerProfitsRepositoryInterface $marketerProfitsRepository;
    public function __construct(MarketerProfitsRepositoryInterface $marketerProfitsRepository){
        $this->marketerProfitsRepository = $marketerProfitsRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function marketer_profits_index()
    {
        return $this->marketerProfitsRepository->profits_all();
    }

    public function marketer_search_profits(Request $request){
        return $this->marketerProfitsRepository->search_profits($request->query('q'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function marketer_payments_index()
    {
        return $this->marketerProfitsRepository->payments_all();
    }

    public function marketer_search_payments(Request $request){
        return $this->marketerProfitsRepository->search_payments($request->query('q'));
    }

    public function marketer_payments_update_type(Request $request){
        return $this->marketerProfitsRepository->marketer_payments_update_type($request->all());
    }
}
