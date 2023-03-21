<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class MarketerPayment extends Model
{
    use HasFactory;

    protected $appends = [
        'status_text'
    ];

     protected $fillable = [
        'marketer_id',
        'value',
        'payment_status',
        'notice'
    ];

    public function marketer()
    {
        return $this->belongsTo('App\Models\Marketer','marketer_id','id');
    }

    public function StatusText(): Attribute
    {
        $status = [
            '0' => 'انتظار الموافقة',
            '1' => 'مكتمل ',
            '2' => 'مرفوض',
            '3' => 'طلب ملغي'
        ];
        return Attribute::make(
            get : fn() => $status[$this->payment_status] ?: ''
        );
    }

    public function CreatedAt(): Attribute
    {
        return Attribute::make(
            get : fn() => date('Y-m-d h:i:s',$this->create_at)
        );
    }
}
