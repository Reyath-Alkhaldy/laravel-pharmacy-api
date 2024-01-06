<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Symfony\Component\Intl\Countries;

class OrderAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id','email','phone_number',
        'street_address','city','postal_code' ];

        public $timestamps = false;

        public function order(){
            $this->belongsTo(Order::class);
        }
        // public function address()
        // {   
        // }
        // public function getNameAttribute()
        // {
        //     return $this->first_name . ' '. $this->last_name;
        // }
        // public function getCountryNameAttribute()
        // {
        //     return  Countries::getName($this->country);
        // }
    
}
