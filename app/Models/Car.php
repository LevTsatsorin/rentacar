<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'brand',
        'model',
        'year',
        'daily_price',
        'transmission',
        'seats',
        'image',
        'is_available',
        'description',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'daily_price' => 'decimal:2',
        'year' => 'integer',
        'seats' => 'integer',
    ];

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_available', true);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->brand} {$this->model}";
    }
}
