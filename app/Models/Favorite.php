<?php

namespace App\Models;

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

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'favorites';

    protected $fillable = ['id', 'user_id', 'medicine_id'];

    public static function booted()
    {
        static::observe(FavoriteObserver::class);
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
