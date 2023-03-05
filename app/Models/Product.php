<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Http\Resources\Image as ImageResource;
use App\Http\Resources\ImageCollection as ImageCollectionResource;

class Product extends Model
{
    use HasFactory;

    protected $appends = [
        'thumbnail_item','attachments_items','status_text'
    ];
    protected $fillable = [
        'name','price','quantity','description','status','merchant_id','marketer_commission','merchant_commission'
    ];

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

     public function StatusText(): Attribute
    {
        $status = [
            '0' => 'مفعل',
            '1' => 'غير مفعل',
        ];
        return Attribute::make(
            get : fn() => $status[$this->status] ?: ''
        );
    }

    public function merchant(){
        return $this->belongsTo('App\Models\Merchant','merchant_id','id');
    }

    public function order_details(){
        return $this->hasMany('App\Models\OrderDetails','product_id','id');
    }
}
