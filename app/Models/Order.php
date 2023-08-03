<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
        'delivery_notice',
        'marketer_profit',
    ];

    protected $appends = [
       'quantity',
       'total',
       'order_total',
       'total_original',
       'order_status_txt',
       'shipping_status_txt',
       'pending_payment',
       'platforms_profit_from_delivery_cash'
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

    /**
     * Scope a query to only include popular users.
     */
    public function scopeDairyOrders(Builder $query): void
    {
        $query->where([
            'order_status'    => 1,
        ])->where('updated_at', '>=', Carbon::today()->toDateString());
    }

     /**
     * Scope a query to only include popular users.
     */
    public function scopeOrdersOfDeliveryStatus(Builder $query,string $status): void
    {
        $query->where([
            'shipping_status' => $status
        ]);
    }


      /**
     * Scope a query to only include popular users.
     */
    public function scopeOrdersOfOrderStatus(Builder $query,string $status,string $sort = 'asc'): void
    {
        $query->where([
            'order_status' => $status
        ])->orderBy('created_at',$sort);
    }

     /**
     * Scope a query to only include popular users.
     */
    public function scopeWithOrderDetails(Builder $query): void
    {
        $query->join('order_details','orders.id','=','order_details.order_id')->select('orders.*','order_details.unit_price','order_details.quantity');
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

    public function OrderTotal() : Attribute
    {
        return Attribute::make(
            get : fn() => $this->order_details()->sum(DB::Raw('unit_price * quantity')) ?: 0
        );
    }

    public function Total() : Attribute
    {
        return Attribute::make(
            get : fn() => $this->order_total + $this->platforms_profit_from_delivery_cash
        );
    }

    public function MarketerProfit() : Attribute
    {
        return Attribute::make(
            get : fn($value) => $value > 0 ? $value : $this->order_details()->join('products','order_details.product_id','=','products.id')
            ->select('order_details.*','products.merchant_commission as merchant_commission','products.marketer_commission as marketer_commission')
            ->groupby('order_details.id')->sum(DB::Raw('order_details.quantity * ( ((order_details.unit_price - merchant_commission)  * marketer_commission ) / 100)')),
        );
    }


    public function PlatformsProfitFromDeliveryCash() : Attribute
    {
        return Attribute::make(
            get: fn() => (20 * ($this->cash_delivered - $this->order_total) / 100)
        );
    }

    public function TotalOriginal() : Attribute
    {
        return Attribute::make(
            get : fn() => $this->order_details()->join('products','order_details.product_id','=','products.id')
            ->sum(DB::raw('products.merchant_commission * order_details.quantity'))
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

    public function PendingPayment() : Attribute
    {
        $status = true;
        if($this->order_status == 2):
            if(strtotime(Date('d-m-Y')) > strtotime('+7 day',strtotime($this->created_at)) ):
                $status = false;
            endif;
        endif;
        return Attribute::make(
            get : fn() => $status
        );
    }
}

