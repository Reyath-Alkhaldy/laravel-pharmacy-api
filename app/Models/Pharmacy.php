<?php

namespace App\Models;

use App\Observers\PharmacyObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pharmacy extends Model
{
   use HasFactory;

   protected $fillable = [
      'name', 'password', 'username', 'address', 'number_of_view_days', 'status', 'image', 'phone_number',

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
   //  protected $appends = ['image_url'];

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

   public static function booted()
   {
      parent::booted();

      self::observe(PharmacyObserver::class);
   }

   public function medicines()
   {
      return $this->hasMany(Medicine::class);
   }
   public function city()
   {
       return $this->belongsTo(City::class);
   }
}
