<?php

namespace App\Models;

use App\Observers\PharmacyObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
      'name', 'password',  'address', 'number_of_view_days', 'status', 'logo_image' ,'phone_number',

  ];

     public static function booted()
     {
        parent::booted();

        self::observe(PharmacyObserver::class);
     }
}
