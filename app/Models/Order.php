<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'marketer_id',
        'delivery_id',
        'order_status',
        'shipping_status',
        'track_notice_order',
        'cash_delivered',
        'cash_delivery_refund',
        'delivery_notice'
    ];

    protected $appends = [
       'quantity',
       'total',
       'order_status_txt',
       'shipping_status_txt'
    ];

    public function marketer(){
        return $this->belongsTo('App\Models\Marketer','marketer_id','id');
    }

    public function delivery(){
        return $this->belongsTo('App\Models\Delivery','delivery_id','id');
    }

    public function customer(){
        return $this->belongsTo('App\Models\Customer','customer_id','id');
    }

    public function order_details(){
        return $this->hasMany('App\Models\OrderDetails','order_id','id');
    }

    public function Quantity() : Attribute
    {
        return Attribute::make(
            get : fn() => $this->order_details()->sum('quantity')
        );
    }

    public function Total() : Attribute
    {
        return Attribute::make(
            get : fn() => $this->order_details()->selectRaw('sum(unit_price * quantity) as total')->first()->total ?: 0
        );
    }

    public function OrderStatusTxt(): Attribute
    {
        $status = [
            '0' => 'انتظار الموافقة',
            '1' => 'جاري التنفيذ',
            '2' => 'مكتمل ',
            '3' => 'مرفوض',
            '4' => 'ملغي'
        ];
        return Attribute::make(
            get : fn() => $this->order_status != null ? $status[$this->order_status] : ''
        );
    }

    public function ShippingStatusTxt(): Attribute
    {
        $shipment_status = [
            '0' => 'انتظار الموافقة',
            '1' => 'جاري التنفيذ',
            '2' => 'مكتمل ',
            '3' => 'مرفوض',
            '4' => 'مرتجع'
        ];
        return Attribute::make(
            get : fn() => $this->shipping_status != null ? $shipment_status[$this->shipping_status] : ''
        );
    }

    public function CreatedAt() : Attribute
    {
        return Attribute::make(
            get : fn($value,$attributes) => $attributes['created_at']
        );
    }
}

