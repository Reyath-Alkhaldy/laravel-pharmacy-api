<?php

namespace App\Models;

use App\Observers\PharmacyObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

     public static function booted()
     {
        parent::booted();

        self::observe(PharmacyObserver::class);
     }
}
