<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class OrderDetails extends Model
{
    use HasFactory;

    protected $appends = [
        'sub_total',
        'product_name'
    ];

    protected $fillable = ['order_id', 'quantity', 'unit_price', 'discount'];

    public function order(){
        return $this->belongsTo('App\Models\Order','order_id','id');
    }

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }

    public function ProductName() : Attribute
    {
        return Attribute::make(
            get : fn() => $this->product->name
        );
    }

     public function CreatedAt() : Attribute
    {
        return Attribute::make(
            get : fn($value,$attributes) => $attributes['created_at']
        );
    }

    public function SubTotal() : Attribute
    {
        return Attribute::make(
            get : fn() => ($this->unit_price * $this->quantity)
        );
    }
}
