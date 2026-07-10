<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Reserva (alquiler) de un vehículo realizada por un usuario.
 */
class Booking extends Model
{
    /**
     * Atributos asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'car_id',
        'plan_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
    ];

    /**
     * Conversiones de tipo de los atributos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    /**
     * Usuario que realizó la reserva.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Vehículo reservado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Plan de alquiler aplicado a la reserva.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Pago asociado a la reserva.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Etiqueta legible del estado de la reserva.
     *
     * @return string
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'confirmed' => 'Confirmado',
            'pending' => 'Pendiente',
            'cancelled' => 'Cancelado',
            default => ucfirst($this->status),
        };
    }

    /**
     * Clases CSS del badge según el estado de la reserva.
     *
     * @return string
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'confirmed' => 'text-bg-success',
            'pending' => 'text-bg-warning',
            'cancelled' => 'text-bg-danger',
            default => 'text-bg-secondary',
        };
    }
}
