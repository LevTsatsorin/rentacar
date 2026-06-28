<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Vehículo disponible para alquiler en el catálogo.
 */
class Car extends Model
{
    /**
     * Atributos asignables masivamente.
     *
     * @var array<int, string>
     */
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

    /**
     * Conversiones de tipo de los atributos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_available' => 'boolean',
        'daily_price' => 'decimal:2',
        'year' => 'integer',
        'seats' => 'integer',
    ];

    /**
     * Reservas (alquileres) asociadas al vehículo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Filtra únicamente los vehículos disponibles.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_available', true);
    }

    /**
     * Nombre completo del vehículo (marca y modelo).
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->brand} {$this->model}";
    }
}
