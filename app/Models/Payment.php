<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Pago de una reserva procesado con MercadoPago.
 */
class Payment extends Model
{
    /**
     * Atributos asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'mp_payment_id',
        'preference_id',
        'status',
        'amount',
        'payment_method',
        'paid_at',
    ];

    /**
     * Conversiones de tipo de los atributos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Reserva a la que pertenece el pago.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Indica si el pago fue aprobado.
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}
