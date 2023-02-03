<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Merchant extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'phone'       => $this->phone,
            'created_at'  => $this->created_at,
            'products'    => $this->products,
            'orders'      => $this->orders,
            'total_sales' => $this->total_sales,
            'account_type'=> $this->name,
            'status'      => $this->status,
            'payments_total' => $this->payments_total,
            'payments_due' => $this->payments_due,
            'payments_made'  => $this->payments_made
        ];
    }
}
