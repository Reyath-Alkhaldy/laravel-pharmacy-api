<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Consultation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'user_id', 'doctor_id', 'text',
        'image', 'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['image'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['image_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    /**
     * Scope a query to only include filter
     *
     * @param  Mixin|array|string $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'user_id' => null,
            'doctor_id' => null,
        ], $filters);
        $builder->when($options['user_id'], function ($query, $value) {
            $query->where('user_id', $value);
        });
        $builder->when($options['doctor_id'], function ($query, $value) {
            $query->where('doctor_id', $value);
        });
    }

    /**
     * Scope a query to only include 
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param   array $filters
     */
    public function scopeFilt(Builder $builder, $filters)
    {
        $options = array_merge([
            'user_id' => Auth::guard('sanctum')->id(),
        ], $filters);
        $builder->when($options['user_id'], function ($query, $value) {
            $query->where('user_id', $value)->latest();
            //   $query->select('doctor_id') ;
            $query->select('doctor_id', DB::raw('count(doctor_id) as count'));
            $query->groupBy('doctor_id');
            $query->with('doctor');
            //   $query->whereExists(function($builder) use ($query){

            //   });            
            //   $query->whereHas('doctor',function($bulder)use ($query){
            //     $bulder->whereIn('id',$query);
            //   });

        });
        // $builder->when($options['user_id'], function ($query,$value) {
        //     $query->where('user_id', $value );
        // });

    }

    public function getImageUrlAttribute()
    {
        if (!$this->image)
            return null;
        if (Str::startsWith($this->image, ['https://', 'http://']))
            return $this->image;

        return   asset('consultations/' . $this->image);
    }
}
