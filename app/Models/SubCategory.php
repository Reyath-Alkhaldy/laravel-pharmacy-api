<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar','name_en','image_url','main_category_id',
    ];
      
    public function mainCategory(){
        return $this->belongsTo(MainCategory::class);
    }
}
