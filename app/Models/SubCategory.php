<?php

namespace App\Models;

use App\Traits\FillableTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory,FillableTraits;
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function products(){
        return $this->hasMany(Product::class,'subcategory_id');
    }
}
