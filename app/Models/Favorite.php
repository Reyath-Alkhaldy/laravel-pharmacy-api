<?php

namespace App\Models;

use App\Observers\CartObserver;
use App\Observers\FavoriteObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Favorite extends Pivot
{
    use HasFactory;
    public $incrementing = false;
    // protected $keyType = 'string';
    protected $hidden = ['updated_at'];


    protected $fillable = ['id', 'user_id', 'medicine_id', 'device_id'];

    public static function booted()
    {
        static::observe(FavoriteObserver::class);
        static::addGlobalScope('device_id', function (Builder $builder) {
            $builder->where('device_id', static::getDeviceId());
        });
    }
    public static function  getDeviceId()
    {
        $device_id = request()->input('device_id');
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
        return $this->belongsTo(Medicine::class);
    }
}
