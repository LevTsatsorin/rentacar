<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controlador del catálogo de autos (listado y detalle).
 */
class CarController extends Controller
{
    /**
     * Lista los autos disponibles con filtros por transmisión, marca y búsqueda.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $query = Car::available();

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->input('transmission'));
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->input('brand'));
        }

        if ($request->filled('q')) {
            $term = $request->input('q');
            $query->where(function ($q) use ($term) {
                $q->where('brand', 'like', "%{$term}%")
                  ->orWhere('model', 'like', "%{$term}%");
            });
        }

        $cars = $query->orderBy('brand')->paginate(9)->withQueryString();
        $brands = Car::available()->select('brand')->distinct()->orderBy('brand')->pluck('brand');

        return view('cars.index', compact('cars', 'brands'));
    }

    /**
     * Muestra el detalle de un auto a partir de su identificador.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(int $id): View
    {
        $car = Car::findOrFail($id);

        return view('cars.show', compact('car'));
    }
}
