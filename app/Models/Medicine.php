<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en', 'name_ar',  'image', 'price', 'count', 'status', 'description', 'sub_category_id', 'pharmacy_id'
    ];
    protected $hidden = ['created_at', 'updated_at','image'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['image_url'];
    /**
     * Get the image_url
     *
     * @param  string  $value
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if(!$this->image)
        return "https://via.placeholder.com/600x600.png/0077ff?text=aut";
        if(Str::startsWith($this->image, ['https://','http://']))
            return $this->image;

        return   asset('storage/'.$this->image);
    }
    
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function scopeActive(Builder $Builder )
    {
        $Builder->where('status','active');
    }


    /**
     * Scope a query to only include 
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query)
    {
        return $query->where('');
    }



}
