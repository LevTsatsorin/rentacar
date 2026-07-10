<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Gestiona el perfil del usuario autenticado: datos personales e historial.
 */
class ProfileController extends Controller
{
    /**
     * Muestra los datos del usuario y su historial de reservas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        $recentBookings = $user->bookings()->with('car', 'plan')->latest()->limit(5)->get();
        $bookingsCount = $user->bookings()->count();

        return view('profile.show', compact('user', 'recentBookings', 'bookingsCount'));
    }

    /**
     * Muestra el formulario de edición de datos personales.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    /**
     * Actualiza el nombre y el email del usuario autenticado.
     *
     * @param  \App\Http\Requests\UpdateProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();
        $user->update($request->validated());

        return to_route('profile.show')->with('success', 'Tus datos se actualizaron correctamente.');
    }
}
