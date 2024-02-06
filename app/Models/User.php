<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name','email','password',
        'phone_number', 'image','address'
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
        'password', 'remember_token','image',
        'created_at', 'updated_at',
        'two_factor_recovery_codes', 'two_factor_secret','email_verified_at',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function consultaions()
    {
        $this->hasMany(Consultation::class);
    }
    public function getImageUrlAttribute()
    {
        if(!$this->image)
        return "https://via.placeholder.com/600x600.png/0077ff?text=aut";
        if(Str::startsWith($this->image, ['https://','http://']))
            return $this->image;

        return   asset('storage/'.$this->image);
    }
}
