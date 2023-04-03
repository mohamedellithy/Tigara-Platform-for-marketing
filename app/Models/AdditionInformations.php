<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionInformations extends Model
{
    use HasFactory;

    protected $fillable = ['who_you','which_marketing_will_follow'];

    public function marketer(){
        return $this->belongsTo('App\Models\Marketer','marketer_id','id');
    }
}
