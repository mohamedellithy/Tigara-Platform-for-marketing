<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'marketer_id'];

    protected $table="favorits";

    public function products(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }

}
