<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultaion extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'doctor_id', 'text'];

    public function user()
    {
        $this->belongsTo(User::class);
    }
    public function doctor()
    {
        $this->belongsTo(Doctor::class);
    }

}
