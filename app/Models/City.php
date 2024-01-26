<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{

    protected $fillable = [
         'zip_code', 'name',  
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];

}
