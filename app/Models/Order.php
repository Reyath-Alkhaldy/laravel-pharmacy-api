<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
         'pharmacy_id','user_id','number',
         'payment_status','payment_method',
        'status', 'discount','total', 'tax'];
    public function pharmacy(){
       return $this->belongsTo(Pharmacy::class);
    }
    public function user(){
        return $this->belongsTo(User::class)
                ->withDefault(['name' => 'Guest User']);
     }
     public function medicines(){
        return $this->belongsToMany(Medicine::class,'order_medicines','order_id','medicine_id','id','id')
                    ->using(OrderMedicine::class)
                    ->as('OrderMedicine')
                    ->withPivot(['medicine_name','price','quantity','options']);
     }
    
    // public function orderMedicines()
    // {
    //     return $this->belongsTo(OrderMedicine::class);
    // }

     public function addresses(){
        return $this->hasMany(OrderAddress::class,'order_id','id');
     }
     public function billingAddress(){
        return $this->hasOne(OrderAddress::class,'order_id','id')
        ->where('type','billing');
     }
     public function shippingAddress(){
        return $this->hasOne(OrderAddress::class,'order_id','id')
        ->where('type','shipping');
     }


    public static function booted(){
        static::creating(function(Order $order){
            $order->number = Order::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
        // select max(nubmer) from orders where
        $number = Order::whereYear('created_at',$year)->max('number');
        if($number){
            return $number + 1;
        }
        return $year . '00001';
    }
}
