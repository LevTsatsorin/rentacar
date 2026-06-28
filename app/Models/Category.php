<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Categoría de clasificación de los posts del blog.
 */
class Category extends Model
{
    /**
     * Atributos asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    /**
     * Conversiones de tipo de los atributos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Posts que pertenecen a la categoría.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Filtra únicamente las categorías activas.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Clases CSS del badge según el slug de la categoría.
     *
     * @return string
     */
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
