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
            'created_at'   => $this->created_at,
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
            'total_un_paid' => $this->total_un_paid
        ];
    }
}
