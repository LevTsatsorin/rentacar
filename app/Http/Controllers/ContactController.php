<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Services\CarService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controlador de la página de contacto.
 */
class ContactController extends Controller
{
    /**
     * Muestra el formulario de contacto con los autos disponibles y el preseleccionado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Services\CarService  $cars
     * @return \Illuminate\View\View
     */
    public function index(Request $request, CarService $cars): View
    {
        $availableCars = $cars->getAvailableCars();

        $selectedCar = $request->filled('car')
            ? $availableCars->firstWhere('id', (int) $request->input('car'))
            : null;

        return view('pages.contact', compact('availableCars', 'selectedCar'));
    }

    /**
     * Procesa el envío del formulario de contacto y redirige con mensaje de éxito.
     *
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreContactRequest $request): RedirectResponse
    {
        return back()->with('success', 'Tu consulta fue enviada. Te responderemos a la brevedad.');
    }
}
