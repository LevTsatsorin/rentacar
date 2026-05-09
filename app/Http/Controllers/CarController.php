<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarController extends Controller
{
    public function index(Request $request): View
    {
        $query = Car::available();

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->input('transmission'));
        }

        if ($request->filled('seats')) {
            $query->where('seats', '>=', (int) $request->input('seats'));
        }

        if ($request->filled('q')) {
            $term = $request->input('q');
            $query->where(function ($q) use ($term) {
                $q->where('brand', 'like', "%{$term}%")
                  ->orWhere('model', 'like', "%{$term}%");
            });
        }

        $cars = $query->orderBy('brand')->paginate(9)->withQueryString();

        return view('cars.index', compact('cars'));
    }

    public function show(int $id): View
    {
        $car = Car::findOrFail($id);

        return view('cars.show', compact('car'));
    }
}
