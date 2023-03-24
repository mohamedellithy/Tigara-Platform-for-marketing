<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'account_type' => $this->account_type,
            'commission'   => $this->commission,
            'created_at'   => date('Y-m-d h:i:s',strtotime($this->created_at)),
            'email'        => $this->email,
            'id'           => $this->id,
            'name'         => $this->name,
            'orders_details' => $this->orders_details,
            'carts'          => $this->carts ? Cart::collection($this->carts) : null,
            'phone'         => $this->phone,
            'status'        => $this->status,
            'status_text'   => $this->status_text,
            'total_cart_items' => $this->total_cart_items,
            'total_paid'   => $this->total_paid,
            'total_profites' => $this->total_profites,
            'total_sales' => $this->total_sales,
            'total_un_paid' => $this->total_un_paid,
            'total_cart_cost' => $this->total_cart_cost,
            'total_cart_profit' => $this->total_cart_profit,
            'total_merchant_products_sales' => $this->total_merchant_products_sales,
            'total_compelete_orders' => $this->total_compelete_orders,
            'all_marketer_and_platform_orders_profits' => $this->all_marketer_and_platform_orders_profits,
            'total_platform_profits'  => $this->total_platform_profits
        ];
    }
}
