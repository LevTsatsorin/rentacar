<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getBadgeAttribute(): string
    {
        return match ($this->slug) {
            'consejos' => 'bg-info text-white',
            'noticias' => 'bg-success',
            'reviews' => 'bg-warning text-dark',
            default => 'bg-secondary',
        };
    }
}
