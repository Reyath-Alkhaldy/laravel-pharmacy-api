<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;


class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en', 'name_ar', 'scien_name', 'mark_name', 'image',
        'price', 'discount', 'count', 'status', 'description',
        'sub_category_id', 'pharmacy_id'
    ];
    protected $hidden = ['created_at', 'updated_at', 'image'];

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
        if (!$this->image)
            return "https://via.placeholder.com/600x600.png/0077ff?text=aut";
        if (Str::startsWith($this->image, ['https://', 'http://']))
            return $this->image;

        return   asset('pharmacy/' . $this->image);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'medicine_id', 'user_id')
            ->using(Favorite::class);
    }

    public function scopeActive(Builder $Builder)
    {
        $Builder->where('status', 'active');
    }

    /**
     * Scope a query to only include 
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param   array $filters
     */
    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'pharmacy_id' => null,
            'sub_category_id' => null,
            'status' => 'active',
        ], $filters);
        $builder->when($options['pharmacy_id'], function ($query, $value) {
            $query->where('pharmacy_id', $value);
        });
        $builder->when($options['sub_category_id'], function ($query, $value) {
            $query->where('sub_category_id', $value);
        });
        $builder->when($options['status'], function ($query, $value) {
            $query->where('status', $value);
        });

        $builder->when(Auth::guard('sanctum')->check(), function ($query) {
            $query->with(['favorites' => function ($q) {
                $q->where('user_id', Auth::guard('sanctum')->id());
            }]);
        });

        $builder->when(Auth::guard('sanctum')->guest(), function ($query) {
            $query->with(['favorites' => function ($hasMany) {
                // will exclude all rows but flag the relation as loaded
                // and therefore add an empty collection as relation
                $hasMany->whereRaw('1 = 0');
            }]);
        });
        // $builder->when($options['tag_id'],function($query,$value) {

        // $query->whereExists(function($query) use ($value){
        //     $query->select(1)
        //     ->from('product_tag')
        //     ->whereRaw('product_id = product.id')
        //     ->where('tag_id',$value);
        // });

        // $query->whereRaw('id IN (SELECT product_id FROM product_tag WHERE tag_id = ?)',[$value]);
        // $query->whereRaw('EXISTS (SELECT 1 FROM product_tag WHERE tag_id = ? AND product_id = product.id)',[$value]);

        // $query->whereHas('tags', function($builder) use ($value){
        //     $builder->where('tag_id', $value);
        // });
        // });
    }
}
