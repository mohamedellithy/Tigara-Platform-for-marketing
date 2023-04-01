<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
class Cart extends Model
{
    use HasFactory;

    protected $appends = [
        // 'product_info'
    ];

    protected $fillable = ['product_id', 'marketer_id','price','quantity'];

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }

     /**
     * Interact with the user's address.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    // protected function ProductInfo(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn () => $this->product
    //     );
    // }

    public function scopeWithProducts(Builder $query): void
    {
        $query->join('products','carts.product_id','=','products.id')
        ->select('carts.*','products.merchant_commission as merchant_commission','products.marketer_commission as marketer_commission');
    }
}
