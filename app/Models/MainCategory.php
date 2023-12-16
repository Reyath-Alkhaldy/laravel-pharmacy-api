<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar','name_en','image_url',
    ];

    public function subCategories(){
        return $this->hasMany(SubCategory::class,'main_category_id','id');
    }
    

}
