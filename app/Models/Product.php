<?php

namespace App\Models;

use App\Traits\FillableTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory,FillableTraits;

    protected $with = ['images','category','vendor'];
    public function images(){
        return $this->hasMany(MultiImage::class);
    }

    public function category(){
        return $this->belongsTo(category::class,'category_id','id');
    }

    public function vendor(){
        return $this->belongsTo(User::class,'vendor_id','id');
    }

    public function subcategory(){
        return $this->belongsTo(SubCategory::class,'subcategory_id','id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id','id');
    }

}
