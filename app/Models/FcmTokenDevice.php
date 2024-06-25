<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FcmTokenDevice extends Model
{
    use HasFactory;
    protected $fillable = ['id','token','device','tokenable_id','tokenable_type'];

    public function tokenable(){
        return $this->morphTo();
    }
}