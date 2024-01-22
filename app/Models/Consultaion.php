<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

}
