<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Image as ImageResource;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ImageCollection as ImageCollectionResource;

class Product extends Model
{
    use HasFactory;

    protected $appends = [
        'thumbnail_item','attachments_items','status_text','hold_stock','marketer_profit','stock_quantity'
    ];
    protected $fillable = [
        'name','price','quantity','description','status','merchant_id','marketer_commission','merchant_commission','private'
    ];

    protected $casts = [
        'stock_quantity',
    ];

    /**
     * Scope a query to only include users of a given type.
     */
    public function scopeWithMarketerProducts(Builder $query, string $marketer_id): void
    {
        $query->whereHas('marketers',function($query) use($marketer_id){
            $query->where('product_marketers.marketer_id',$marketer_id);
        })->orWhere('private',0);
    }

     /**
     * Scope a query to only include users of a given type.
     */
    public function scopeMoreSales(Builder $query): void
    {
        $query->LeftJoin('order_details','products.id','=','order_details.product_id')
        ->select('products.*',DB::Raw('sum(order_details.quantity) as order_quantity'))
        ->groupBy('products.id')->orderby('order_quantity','desc');
    }

     /**
     * Scope a query to only include users of a given type.
     */
    public function scopeLessSales(Builder $query): void
    {
        $query->LeftJoin('order_details','products.id','=','order_details.product_id')
        ->select('products.*',DB::Raw('sum(order_details.quantity) as order_quantity'))
        ->groupBy('products.id')->orderby('order_quantity','asc');
    }

      /**
     * Scope a query to only include users of a given type.
     */
    public function scopeLowStock(Builder $query): void
    {
        $query->LeftJoin('carts','products.id','=','carts.product_id')
        ->select('products.*',DB::Raw('IFNULL(sum(carts.quantity),0) as cart_quantity'))
        ->groupBy('products.id')->havingRaw('IF(products.quantity >= cart_quantity,products.quantity - cart_quantity,products.quantity) = 0');
    }

       /**
     * Scope a query to only include users of a given type.
     */
    public function scopeAboutToLow(Builder $query): void
    {
        $query->LeftJoin('carts','products.id','=','carts.product_id')
        ->select('products.*',DB::Raw('IFNULL(sum(carts.quantity),0) as cart_quantity'))
        ->groupBy('products.id')->havingRaw('(IF(products.quantity >= cart_quantity,products.quantity - cart_quantity,products.quantity) < 10) AND (IF(products.quantity >= cart_quantity,products.quantity - cart_quantity,products.quantity) > 0 )');
    }

    /**
     * Get all of the images's comments.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * The products that belong to the user.
     */
    public function marketers()
    {
        return $this->belongsToMany('App\Models\Marketer','product_marketers','product_id','marketer_id');
    }

    public function ThumbnailItem(): Attribute
    {
        return Attribute::make(
            get:fn() => new ImageResource($this->images()->where('image_type',0)->first())
        );
    }

    public function AttachmentsItems(): Attribute
    {
        return Attribute::make(
            get:fn() => new ImageCollectionResource($this->images()->where('image_type',1)->get())
        );
    }

    public function MarketerProfit(): Attribute
    {
        $platform = ($this->price - floatval($this->merchant_commission));
        return Attribute::make(
            get:fn() => ($platform * floatval($this->marketer_commission)) / 100
        );
    }

     public function StatusText(): Attribute
    {
        $status = [
            '1' => 'مفعل',
            '0' => 'غير مفعل',
        ];
        return Attribute::make(
            get : fn() => $status[$this->status] ?: ''
        );
    }

    public function StockQuantity(): Attribute
    {
        return Attribute::make(
            get : fn() => ($this->quantity >= $this->hold_stock ? ($this->quantity - $this->hold_stock) : ( $this->quantity ?: 0))
        );
    }

    public function merchant(){
        return $this->belongsTo('App\Models\Merchant','merchant_id','id');
    }

    public function order_details(){
        return $this->hasMany('App\Models\OrderDetails','product_id','id');
    }

    public function cart(){
        return $this->hasMany('App\Models\Cart','product_id','id');
    }

    public function HoldStock(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->cart()->sum('quantity') ?: 0
        );
    }
}
