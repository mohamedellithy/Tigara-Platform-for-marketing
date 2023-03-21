<?php

namespace App\Http\Controllers\Api\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\DeliveryOrdersRepositoryInterface;
use App\Models\Order;
class OrderController extends Controller
{
    //
    protected DeliveryOrdersRepositoryInterface $delivery_orders;
    public function __construct(DeliveryOrdersRepositoryInterface $delivery_orders){
        $this->delivery_orders = $delivery_orders;
    }

    public function index(Request $request){
        return $this->delivery_orders->all($request);
    }

    public function search(Request $request){
        return $this->delivery_orders->search($request);
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

        return $this->delivery_orders->update($request->all(),$id);
    }

    public function bulk_update_status(Request $request){
        return $this->delivery_orders->bulk_update_status($request->all());
    }

    public function show(Request $request,$id){
        return $this->delivery_orders->show($request,$id);
    }
}
