<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    protected OrderRepositoryInterface $orderRepository;
    public function __construct(orderRepositoryInterface $orderRepository){
        $this->orderRepository = $orderRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return $this->orderRepository->all($request);
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //
        return $this->orderRepository->search($request);
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
        return $this->orderRepository->show($id);
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
        if($request->has('shipping_status') && $request->input('shipping_status') == '2'):
            $order = Order::find($id);
            $request->validate([
                'cash_delivered' => 'sometimes|gt:'.$order->order_total ?: 0
            ]);
        endif;
        return $this->orderRepository->update($request->all(),$id);
    }

    public function bulk_update_status(Request $request){
        return $this->orderRepository->bulk_update($request->all());
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
        return $this->orderRepository->delete($id);
    }
}
