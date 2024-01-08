<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderMedicine extends Pivot
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'medicine_id', 'medicine_name',
        'price', 'quantity', 'options'
    ];
    protected $table = 'order_medicines';
    // public $timestamps = false;
    public $incrementing = true;

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    //         ->withDefault([
    //             'medicine_name' => $this->medicine_name,
    //         ]);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
