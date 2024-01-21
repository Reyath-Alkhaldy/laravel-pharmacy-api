<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;
    // protected $keyType = 'string';
    protected $hidden = ['created_at','updated_at','options'];


    protected $fillable = ['id','pharmacy_id','user_id','medicine_id','quantity','options','device_id',];

    public static function booted()
    {
        static::observe(CartObserver::class);
        static::addGlobalScope('device_id',function(Builder $builder){
            $builder->where('device_id', static::getDeviceId());
        });

        // static::creating(function(Cart $cart){
        //     $cart->id = Str::uuid();
        // });

    }
    public static function  getDeviceId(){
        $device_id = request()->input('device_id');
        // if(!$device_id){
        //     $device_id = Str::uuid();
        //     Cookie::queue('cart_id',$device_id, 30 * 24 * 60);
        // }
        return $device_id;
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest User'
        ]);
    }
    public function medicine()
    {
        return $this->belongsTo(Medicine::class) ;
    }
}
