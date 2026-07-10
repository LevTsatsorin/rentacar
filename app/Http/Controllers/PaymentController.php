<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Gestiona el circuito de pago con MercadoPago (sandbox).
 */
class PaymentController extends Controller
{
    /**
     * Crea la preferencia de pago y redirige al checkout de MercadoPago.
     *
     * @param  \App\Models\Booking  $booking
     * @param  \App\Services\PaymentService  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(Booking $booking, PaymentService $service): RedirectResponse
    {
        abort_unless((int) $booking->user_id === (int) Auth::id(), 403);

        if (! $service->isEnabled()) {
            return back()->with('error', 'El pago online no está disponible en este momento.');
        }

        $initPoint = $service->createPreference($booking);

        if (! $initPoint) {
            return back()->with('error', 'No se pudo iniciar el pago. Intentá nuevamente más tarde.');
        }

        return redirect()->away($initPoint);
    }

    /**
     * Página de retorno tras un pago aprobado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Services\PaymentService  $service
     * @return \Illuminate\View\View
     */
    public function success(Request $request, PaymentService $service): View
    {
        $booking = $this->ownedBooking($request);

        if ($booking && $service->isEnabled()) {
            $service->refreshStatus($booking);
            $booking->refresh();
        }

        return view('payment.success', [
            'booking' => $booking,
            'pending' => $booking !== null && $booking->status !== 'confirmed',
        ]);
    }

    /**
     * Página de retorno tras un pago rechazado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function failure(Request $request): View
    {
        $booking = $this->ownedBooking($request);

        return view('payment.error', compact('booking'));
    }

    /**
     * Página de retorno tras un pago pendiente de acreditación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Services\PaymentService  $service
     * @return \Illuminate\View\View
     */
    public function pending(Request $request, PaymentService $service): View
    {
        $booking = $this->ownedBooking($request);

        if ($booking && $service->isEnabled()) {
            $service->refreshStatus($booking);
            $booking->refresh();
        }

        return view('payment.success', [
            'booking' => $booking,
            'pending' => $booking === null || $booking->status !== 'confirmed',
        ]);
    }

    /**
     * Verifica manualmente el estado del pago consultando a MercadoPago.
     * Pensado para localhost, donde el webhook no llega.
     *
     * @param  \App\Models\Booking  $booking
     * @param  \App\Services\PaymentService  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refresh(Booking $booking, PaymentService $service): RedirectResponse
    {
        abort_unless((int) $booking->user_id === (int) Auth::id(), 403);

        if (! $service->isEnabled()) {
            return back()->with('error', 'El pago online no está disponible en este momento.');
        }

        $status = $service->refreshStatus($booking);

        return match ($status) {
            'approved' => back()->with('success', '¡Pago acreditado! Tu reserva quedó confirmada.'),
            'pending', 'in_process' => back()->with('error', 'El pago todavía está pendiente de acreditación. Probá de nuevo en unos minutos.'),
            'rejected', 'cancelled' => back()->with('error', 'El pago fue rechazado. Podés reintentar el pago.'),
            default => back()->with('error', 'Aún no encontramos un pago para esta reserva.'),
        };
    }

    /**
     * Notificación (webhook) de MercadoPago para sincronizar el estado del pago.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Services\PaymentService  $service
     * @return \Illuminate\Http\Response
     */
    public function webhook(Request $request, PaymentService $service): Response
    {
        $paymentId = $request->input('data.id') ?? $request->query('id');

        if ($paymentId && $service->isEnabled()) {
            $service->syncFromMercadoPago((string) $paymentId);
        }

        return response('OK', 200);
    }

    /**
     * Resuelve la reserva referenciada si pertenece al usuario autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Booking|null
     */
    private function ownedBooking(Request $request): ?Booking
    {
        $booking = Booking::find($request->query('external_reference'));

        return $booking && (int) $booking->user_id === (int) Auth::id() ? $booking : null;
    }
}
