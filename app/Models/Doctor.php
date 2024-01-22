<?php

namespace App\Models;

use Carbon\Traits\Mixin;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;


class Doctor extends  Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['image_url'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'email_verified_at',
        'remember_token',
        'image', 'created_at', 'updated_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', 
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image)
            return "https://via.placeholder.com/600x600.png/0077ff?text=aut";
        if (Str::startsWith($this->image, ['https://', 'http://']))
            return $this->image;

        return   asset('storage/' . $this->image);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
    public function consultaions()
    {
        $this->hasMany(Consultaion::class);
    }

    /**
     * Scope a query to only include filter
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  Mixin|array|string $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'specialty_id' => null,
        ], $filters);
        $builder->when($options['specialty_id'], function ($query, $value) {
            $query->where('specialty_id', $value);
        });
    }
}
