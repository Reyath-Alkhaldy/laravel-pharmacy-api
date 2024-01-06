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


    protected $fillable = ['pharmay_id','user_id','medicine_id','quantity','options',];

    public static function booted()
    {
        static::observe(CartObserver::class);
        // static::addGlobalScope('cookie_id',function(Builder $builder){
        //     $builder->where('cookie_id', static::getCookieId());
        // });

        // static::creating(function(Cart $cart){
        //     $cart->id = Str::uuid();
        // });

    }
    // public static function  getCookieId(){
    //     $cookie_id = Cookie::get('cart_id');
    //     if(!$cookie_id){
    //         $cookie_id = Str::uuid();
    //         Cookie::queue('cart_id',$cookie_id, 30 * 24 * 60);
    //     }
    //     return $cookie_id;
    // }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function medicine()
    {
        return $this->belongsTo(Medicine::class) ;
    }
}
