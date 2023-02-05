<?php

namespace App\Models;

use App\Models\Scopes\DeliveryScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Delivery extends Authenticatable
{
     use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $guard = "delivery";

    protected $primaryKey = 'id';

    protected $appends = [
        'payments_total',
        'payments_due',
        'payments_made',
        'status_text'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'account_type',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'payments_total'    => 'string'
    ];

     /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new DeliveryScope);
    }

    /**
     * Interact with the user's address.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function statusText(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status == 0 ? 'غير مفعل' : 'مفعل'
        );
    }

    public function delivery_payments(){
        return $this->hasMany('App\Models\DeliveryPayment','delivery_id','id');
    }

    public function orders(){
        return $this->hasMany('App\Models\Order','delivery_id','id');
    }

    public function totalSales() : Attribute
    {
        return Attribute::make(
        get: fn() => $this->orders->sum(function ($order_details) {
                return $order_details['unit_price'] * $order_details['quantity'];
            })
        );
    }

    public function paymentsTotal(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->delivery_payments()->where('type','0')->sum('value'),
        );
    }

    public function paymentsDue(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->delivery_payments()->where('type','0')->sum('value') - $this->delivery_payments()->where('type','1')->sum('value'),
        );
    }

    public function paymentsMade(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->delivery_payments()->where('type','1')->sum('value'),
        );
    }

}
