<?php

namespace App\Models;

use App\Models\Scopes\MerchantScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;
class Merchant extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $guard = "merchant";

    protected $primaryKey = 'id';

    protected $appends = [
        'payments_total',
        'payments_due',
        'payments_made',
        'total_sales',
        'total_pending',
        'total_merchant_products_sales',
        'total_compelete_orders',
        'total_platform_profits'
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
        'commission',
        'status',
        'account_type',
        'store_name',
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
        static::addGlobalScope(new MerchantScope);
    }

    /**
     * Interact with the user's address.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function statusText(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => 'hi',
                //$attributes['status'] == 0 ? 'غير مفعل' : 'مفعل'
            set: fn ($value) => 'hi'
        );
    }

    public function merchant_payments(){
        return $this->hasMany('App\Models\MerchantPayment','merchant_id','id');
    }

    public function products(){
        return $this->hasMany('App\Models\Product','merchant_id','id');
    }

    public function orders(){
        return $this->hasManyThrough('App\Models\OrderDetails','App\Models\Product','merchant_id','product_id','id','id');
    }

    public function order_details(){
        return $this->hasManyThrough('App\Models\OrderDetails','App\Models\Product','merchant_id','product_id','id','id');
    }

    public function totalCompeleteOrders() : Attribute
    {
        return Attribute::make(
            get: fn() => $this->order_details()->whereHas('order',function($query){
                $query->where('order_status',2);
            })->count()
        );
    }
    public function totalSales() : Attribute
    {
        return Attribute::make(
            get: fn() => $this->order_details()->whereHas('order',function($query){
                $query->where('order_status',2);
            })->sum(DB::Raw('order_details.unit_price * order_details.quantity'))
        );
    }

    public function totalMerchantProductsSales() : Attribute
    {
        return Attribute::make(
            get: fn() => $this->order_details()->whereHas('order',function($query){
                $query->where('order_status',2);
            })->sum(DB::Raw('products.merchant_commission * order_details.quantity'))
        );
    }

    public function TotalPlatformProfits() : Attribute
    {
        return Attribute::make(
            get: fn() => $this->total_sales - $this->total_merchant_products_sales
        );
    }

    public function paymentsTotal(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->merchant_payments()->where('type','0')->sum('value'),
        );
    }

    public function paymentsDue(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->merchant_payments()->where('type','0')->sum('value') - $this->merchant_payments()->where('type','1')->sum('value'),
        );
    }

    public function paymentsMade(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->merchant_payments()->where('type','1')->sum('value'),
        );
    }

    public function TotalPending(): Attribute
    {
        $startDate = now()->subDays(7);
        return Attribute::make(
            get: fn() => $this->merchant_payments()
            ->where('item_id','!=',null)->where('updated_at','>=',$startDate)->sum('value'),
        );
    }
    
}
