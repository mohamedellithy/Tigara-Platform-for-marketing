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

    protected $appends = ['type_text','pending_payment'];

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

    public function PendingPayment() : Attribute
    {
        $status = true;
        if($this->item_id == null):
            $status = false;
        else:
            if(strtotime(Date('d-m-Y')) > strtotime('+7 day',strtotime($this->created_at)) ):
                $status = false;
            endif; 
        endif;
        return Attribute::make(
            get : fn() => $status
        );
    }
}
