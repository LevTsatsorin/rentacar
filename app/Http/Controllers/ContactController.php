<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        $availableCars = Car::available()->orderBy('brand')->get();

        $selectedCar = $request->filled('car')
            ? $availableCars->firstWhere('id', (int) $request->input('car'))
            : null;

        return view('pages.contact', compact('availableCars', 'selectedCar'));
    }
}
