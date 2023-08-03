<?php

namespace App\Models;

use App\Models\Scopes\MarketerScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;
class Marketer extends Authenticatable
{
     use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $guard = "marketer";

    protected $primaryKey = 'id';

    protected $appends = [
        'status_text',
        'total_sales',
        'total_profites',
        'total_paid',
        'total_un_paid',
        'total_cart_items',
        'total_profit_pending',
        'total_compelete_orders',
        'total_platform_profits',
        'all_marketer_and_platform_orders_profits'
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
        static::addGlobalScope(new MarketerScope);
    }

    /**
     * The products that belong to the user.
     */
    public function products()
    {
        return $this->belongsToMany('App\Models\Product','product_marketers','marketer_id','product_id');
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

    public function orders(){
        return $this->hasMany('App\Models\Order','marketer_id','id');
    }

    public function carts(){
        return $this->hasMany('App\Models\Cart','marketer_id','id');
    }

    public function payments(){
        return $this->hasMany('App\Models\MarketerPayment','marketer_id','id');
    }

    public function orders_details(){
        return $this->hasManyThrough('App\Models\OrderDetails','App\Models\Order','marketer_id','order_id','id','id');
    }

    public function addition_informations(){
        return $this->hasOne('App\Models\AdditionInformations','marketer_id','id');
    }

    public function favourites(){
        return $this->hasMany('App\Models\Favourite','marketer_id','id');
    }

    public function products_favourits(){
        return $this->hasManyThrough('App\Models\Product','App\Models\Favourite','marketer_id','id','id','product_id');
    }

    public function totalSales() : Attribute
    {
        return Attribute::make(
            get: fn() => $this->orders()->where('order_status',2)
            ->join('order_details','orders.id','=','order_details.order_id')->select('orders.*','order_details.unit_price','order_details.quantity')
            ->sum(DB::Raw('order_details.unit_price * order_details.quantity'))
        );
    }

    public function totalCompeleteOrders():Attribute
    {
        return Attribute::make(
            get: fn() => $this->orders()->where('order_status',2)->count()
        );
    }

    public function totalProfites():Attribute
    {
        return Attribute::make(
            get: fn() => $this->orders()->where('order_status',2)->sum('marketer_profit')
        );
    }

    public function AllMarketerAndPlatformOrdersProfits() : Attribute
    {
        return Attribute::make(
            get: fn() =>  $this->orders()->where('order_status',2)
            ->join('order_details','orders.id','=','order_details.order_id')
            ->join('products','order_details.product_id','=','products.id')
            ->select('orders.*','order_details.unit_price','order_details.quantity','products.merchant_commission')
            ->sum(DB::Raw('(order_details.unit_price - products.merchant_commission) * order_details.quantity'))
        );
    }

    public function TotalPlatformProfits() : Attribute
    {
        return Attribute::make(
            get: fn() => $this->all_marketer_and_platform_orders_profits - $this->total_profites
        );
    }

    public function totalPaid():Attribute
    {
        return Attribute::make(
        get: fn() => $this->payments()->where('payment_status',1)->sum('value')
        );
    }

    public function totalUnPaid():Attribute
    {
        return Attribute::make(
            get: fn() => $this->total_profites - $this->total_paid
        );
    }

    public function TotalCartItems() : Attribute
    {
        return Attribute::make(
            get: fn() => $this->carts()->sum('quantity')
        );
    }

    public function TotalProfitPending(): Attribute
    {
        $startDate = now()->subDays(7);
        return Attribute::make(
            get: fn() => $this->orders()
            ->where('orders.order_status','=',2)->where('orders.updated_at','>=',$startDate)->sum('marketer_profit'),
        );
    }

    // public function merchant_payments(){
    //     return $this->hasMany('App\Models\MerchantPayment','merchant_id','id');
    // }

    // public function paymentsTotal(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn() => $this->merchant_payments()->where('type','0')->sum('value'),
    //     );
    // }

    // public function paymentsDue(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn() => $this->merchant_payments()->where('type','0')->sum('value') - $this->merchant_payments()->where('type','1')->sum('value'),
    //     );
    // }

    // public function paymentsMade(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn() => $this->merchant_payments()->where('type','1')->sum('value'),
    //     );
    // }
}
