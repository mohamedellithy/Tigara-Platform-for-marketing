<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class DeliveryPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'delivery_id',
        'order_id',
        'value',
        'type'
    ];

    protected $appends = ['type_text'];

    public function delivery(){
        return $this->belongsTo('App\Models\Delivery','id','delivery_id');
    }

    public function order(){
        return $this->belongsTo('App\Models\Order','order_id','id');
    }

     public function TypeText(): Attribute
    {
        $status = [
            '0' => 'مستحقة',
            '1' => 'مسددة '
        ];
        return Attribute::make(
            get : fn() => $status[$this->type] ?: ''
        );
    }

    public function CreatedAt() : Attribute
    {
        return Attribute::make(
            get : fn($value,$attributes) => $attributes['created_at']
        );
    }

}
