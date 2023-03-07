<?php 
namespace App\Services;
use App\Models\Order;
use App\Models\Product;
use App\Services\StockService;
class OrderActionsProcess{
    protected Order $order;

    public function __construct(Order $order){
        $this->order = $order;
    }

    public function handle_process_order_status(){
        $status = [
            '0'  =>'wait',
            '1'  =>'process',
            '2'  =>'complete',
            '3'  =>'refused',
            '4'  =>'cancel'
        ];

        $order_status = $status[$this->order->order_status];

        if(method_exists($this,"order_in_case_{$order_status}")):
            // call the order action
            $this->{"order_in_case_{$order_status}"}();
        endif;
    }

    public function order_stock_availability(){
        // process order items
        foreach($this->order->order_details as $item):
            // handle order quantity and decrement product quantity
            $stock = new StockService(
                Product::find($item->product_id)
            );

            // set quantity
            $stock->required_quantity = $item->quantity;

            if($stock->stock_availaibility() == false):
                return false;
            endif;

        endforeach;

        return true;
    }

    protected function order_in_case_wait(){

        // here write code put wait order
        if($this->order->order_status != '0') return;

        // process order items
        foreach($this->order->order_details as $item):

            // handle order quantity and decrement product quantity
            $stock = new StockService(
                Product::find($item->product_id)
            );

            // set quantity
            $stock->required_quantity = $item->quantity;

            // decrease stock quantity
            $stock->decrease_stock();

        endforeach;
    }

    protected function order_in_case_cancel(){
        // here write code put cancel order
        if($this->order->order_status != '4') return;

        // process order items
        foreach($this->order->order_details as $item):

            // handle order quantity and decrement product quantity
            $stock = new StockService(
                Product::find($item->product_id)
            );

            // set quantity
            $stock->required_quantity = $item->quantity;

            // increase stock quantity
            $stock->increase_stock();

        endforeach;
    }

    protected function order_in_case_process(){
        // here write code put cancel order
    }

    protected function order_in_case_complete(){
        // here write code put cancel order
    }

    protected function order_in_case_refused(){
        // here write code put refused order
        if($this->order->order_status != '3') return;

        // process order items
        foreach($this->order->order_details as $item):

            // handle order quantity and decrement product quantity
            $stock = new StockService(
                Product::find($item->product_id)
            );

            // set quantity
            $stock->required_quantity = $item->quantity;

            // increase stock quantity
            $stock->increase_stock();

        endforeach;
    }

    protected function order_in_case_refund(){
        // here write code put refund order
        if($this->order->order_status != '0') return;

        // process order items
        foreach($this->order->order_details as $item):

            // handle order quantity and decrement product quantity
            $stock = new StockService(
                Product::find($item->product_id),
                $item->quantity
            );

            // increase stock quantity
            $stock->increase_stock();

        endforeach;
    }

}