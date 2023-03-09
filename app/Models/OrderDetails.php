<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;
class OrderDetails extends Model
{
    use HasFactory;

    protected $appends = [
        'sub_total',
        'sub_total_original',
        'product_name',
        'sub_marketer_profit'
    ];

    protected $fillable = ['order_id', 'quantity','product_id','unit_price', 'discount'];

    public function order(){
        return $this->belongsTo('App\Models\Order','order_id','id');
    }

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }

    public function merchant_payment(){
        return $this->hasOne('App\Models\MerchantPayment','item_id','id');
    }

    public function SubTotalOriginal() : Attribute
    {
        return Attribute::make(
            get : fn() => intval($this->quantity) * floatval($this->product->merchant_commission)
        );
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

    public function SubMarketerProfit() : Attribute
    {
        return Attribute::make(
            get : fn() => $this->quantity * ( (($this->unit_price - $this->product->merchant_commission)  * $this->product->marketer_commission ) / 100),
        );
    }
}
