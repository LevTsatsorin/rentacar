<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

/**
 * Integración con la API de MercadoPago (Checkout Pro) en modo sandbox.
 */
class PaymentService
{
    /**
     * URL base de la API de MercadoPago.
     */
    private const API = 'https://api.mercadopago.com';

    /**
     * Indica si la integración de pagos está configurada.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (bool) config('services.mercadopago.enabled');
    }

    /**
     * Crea una preferencia de pago y devuelve la URL de checkout (init_point).
     *
     * @param  \App\Models\Booking  $booking
     * @return string|null  URL de checkout, o null si falló la creación.
     */
    public function createPreference(Booking $booking): ?string
    {
        $booking->loadMissing('car');

        $payment = $this->paymentFor($booking);

        $successUrl = route('payments.success');

        $preference = [
            'items' => [[
                'title' => 'Alquiler '.$booking->car->full_name,
                'quantity' => 1,
                'unit_price' => (float) $booking->total_price,
                'currency_id' => 'ARS',
            ]],
            'external_reference' => (string) $booking->id,
            'back_urls' => [
                'success' => $successUrl,
                'failure' => route('payments.failure'),
                'pending' => route('payments.pending'),
            ],
        ];

        if (str_starts_with($successUrl, 'https://')) {
            $preference['auto_return'] = 'approved';
            $preference['notification_url'] = route('payments.webhook');
        }

        $response = Http::withToken(config('services.mercadopago.token'))
            ->post(self::API.'/checkout/preferences', $preference);

        if ($response->failed()) {
            return null;
        }

        $payment->update(['preference_id' => $response->json('id')]);

        return $response->json('sandbox_init_point') ?? $response->json('init_point');
    }

    /**
     * Marca el pago como aprobado y confirma la reserva.
     *
     * @param  \App\Models\Booking  $booking
     * @param  string|null  $mpPaymentId
     * @param  string|null  $method
     * @return void
     */
    public function markApproved(Booking $booking, ?string $mpPaymentId = null, ?string $method = null): void
    {
        $this->paymentFor($booking)->update([
            'status' => 'approved',
            'mp_payment_id' => $mpPaymentId,
            'payment_method' => $method,
            'paid_at' => Carbon::now(),
        ]);

        $booking->update(['status' => 'confirmed']);
    }

    /**
     * Actualiza el estado del pago sin confirmar la reserva.
     *
     * @param  \App\Models\Booking  $booking
     * @param  string  $status
     * @param  string|null  $mpPaymentId
     * @return void
     */
    public function markStatus(Booking $booking, string $status, ?string $mpPaymentId = null): void
    {
        $this->paymentFor($booking)->update([
            'status' => $status,
            'mp_payment_id' => $mpPaymentId,
        ]);
    }

    /**
     * Sincroniza el estado del pago consultando la API de MercadoPago (webhook).
     *
     * @param  string  $mpPaymentId
     * @return void
     */
    public function syncFromMercadoPago(string $mpPaymentId): void
    {
        $response = Http::withToken(config('services.mercadopago.token'))
            ->get(self::API.'/v1/payments/'.$mpPaymentId);

        if ($response->failed()) {
            return;
        }

        $booking = Booking::find($response->json('external_reference'));

        if (! $booking) {
            return;
        }

        if ($response->json('status') === 'approved') {
            $this->markApproved($booking, $mpPaymentId, $response->json('payment_type_id'));
        } else {
            $this->markStatus($booking, (string) $response->json('status'), $mpPaymentId);
        }
    }

    /**
     * Consulta en MercadoPago el último pago de la reserva y actualiza su estado.
     * Útil en localhost, donde el webhook no llega y el retorno puede fallar.
     *
     * @param  \App\Models\Booking  $booking
     * @return string|null  El estado del pago en MercadoPago, o null si no hay pago.
     */
    public function refreshStatus(Booking $booking): ?string
    {
        $response = Http::withToken(config('services.mercadopago.token'))
            ->get(self::API.'/v1/payments/search', [
                'external_reference' => (string) $booking->id,
                'sort' => 'date_created',
                'criteria' => 'desc',
            ]);

        if ($response->failed()) {
            return null;
        }

        $payment = $response->json('results.0');

        if (! $payment) {
            return null;
        }

        $status = $payment['status'] ?? null;
        $mpPaymentId = isset($payment['id']) ? (string) $payment['id'] : null;

        if ($status === 'approved') {
            $this->markApproved($booking, $mpPaymentId, $payment['payment_type_id'] ?? null);
        } elseif ($status) {
            $this->markStatus($booking, $status, $mpPaymentId);
        }

        return $status;
    }

    /**
     * Devuelve (o crea) el pago pendiente asociado a la reserva.
     *
     * @param  \App\Models\Booking  $booking
     * @return \App\Models\Payment
     */
    private function paymentFor(Booking $booking): Payment
    {
        return $booking->payment()->firstOrCreate([], [
            'status' => 'pending',
            'amount' => $booking->total_price,
        ]);
    }
}
