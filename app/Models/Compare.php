<?php

namespace App\Models;

use App\Traits\FillableTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compare extends Model
{
    use HasFactory,FillableTraits;
    public function products(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
