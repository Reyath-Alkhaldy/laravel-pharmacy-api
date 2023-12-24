<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MainCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar', 'name_en', 'image','pharmacy_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at',];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    // protected $appends = ['image_url'];

    /**
     * Get the image_url
     *
     * @param  string  $value
     * @return string
     */
    // public function getImageUrlAttribute()
    // {
    //     if (!$this->image)
    //         return "https://via.placeholder.com/600x600.png/0077ff?text=aut";
    //     if (Str::startsWith($this->image, ['https://', 'http://']))
    //         return $this->image;

    //     return   asset('storage/' . $this->image);
    // }


    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'main_category_id', 'id');
    }
}
