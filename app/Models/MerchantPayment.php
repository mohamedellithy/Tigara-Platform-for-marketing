<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class MerchantPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'value',
        'type',
        'item_id'
    ];

    protected $appends = ['type_text'];

    public function merchant(){
        return $this->belongsTo('App\Models\Merchant','id','merchant_id');
    }

    public function item_details(){
        return $this->belongsTo('App\Models\OrderDetails','item_id','id');
    }

     public function TypeText(): Attribute
    {
        $status = [
            '0' => 'مضافة',
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
