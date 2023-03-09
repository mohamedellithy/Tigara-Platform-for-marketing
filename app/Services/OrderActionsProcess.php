<?php 
namespace App\Services;

use App\Models\MerchantPayment;
use App\Models\DeliveryPayment;
use App\Models\Order;
use App\Models\Product;
use App\Services\StockService;
class OrderActionsProcess{
    protected Order $order;
    public $prev_status_order;

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

        if(!in_array($this->prev_status_order,['0','1','2'])):

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

        endif;

        // remove payments
        $this->change_order_from_complete_to_others();
    }

    protected function order_in_case_cancel(){
        // here write code put cancel order
        if($this->order->order_status != '4') return;

        // if previuos order equal to current order
        if(!in_array($this->prev_status_order,['3','4'])):

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

        endif;

        // remove payments
        $this->change_order_from_complete_to_others();
    }

    protected function order_in_case_process(){
        // here write code put process order
        if($this->order->order_status != '1') return;

        if(!in_array($this->prev_status_order,['0','1','2'])):

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

        endif;

        // remove payments
        $this->change_order_from_complete_to_others();
    }

    protected function order_in_case_complete(){
        // here write code put complete order
        if($this->order->order_status != '2') return;

        if($this->prev_status_order == $this->order->order_status ) return;

        $total_marketer_profits = 0;

        // process order items
        foreach($this->order->order_details as $item):
            // merchant profits
            $total_merchant_profits = $item->quantity * $item->product->merchant_commission;

            // add new payment merchant
            $item->product->merchant->merchant_payments()->updateOrCreate([
                'item_id' => $item->id
            ],[
                'value' => $total_merchant_profits,
                'type'  => 0
            ]);

            // marketer profits
            $rest_of_profits = $item->unit_price - $item->product->merchant_commission;
            $total_marketer_profits += ( ($item->product->marketer_commission * $rest_of_profits) / 100) * $item->quantity;

        endforeach;

        // add profit from marketer to order
        $this->order->update([
            'marketer_profit' => $total_marketer_profits
        ]);

        // delivery profits
        //$total_delivery_profits = $this->order->cash_delivered -  $this->order->total;
        $this->order->delivery->delivery_payments()->updateOrCreate(
            [
                'order_id' => $this->order->id,
            ],
            [
                'value' => $this->order->total,
                'type'  => 0
            ]
        );

        if(!in_array($this->prev_status_order,['0','1','2'])):

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

        endif;
    }

    protected function order_in_case_refused(){
        // here write code put refused order
        if($this->order->order_status != '3') return;

        if($this->prev_status_order == $this->order->order_status ) return;

        // if previuos order equal to current order
        if(!in_array($this->prev_status_order,['3','4'])):

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

        endif;

        // remove payments
        $this->change_order_from_complete_to_others();
    }

    protected function order_in_case_refund(){
        // here write code put refund order
        if($this->order->order_status != '5') return;

        if($this->prev_status_order == $this->order->order_status ) return;

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

        // remove payments
        $this->change_order_from_complete_to_others();
    }

    public function change_order_from_complete_to_others(){
        // here write code put complete order
        if($this->order->order_status == '2') return;

        if($this->order->marketer_profit == 0) return;

        // process order items
        foreach($this->order->order_details as $item):
            // delete merchant payments
            MerchantPayment::where('item_id',$item->id)->delete();
        endforeach;

        // delete delivery payments
        DeliveryPayment::where('order_id',$this->order->id)->delete();

        $this->order->update([
            'marketer_profit' => 0.0,
            'cash_delivered' => 0.0
        ]);
    }

}