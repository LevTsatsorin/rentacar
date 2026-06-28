<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Post;
use App\Models\User;
use Illuminate\View\View;

/**
 * Muestra el panel de administración con estadísticas generales.
 */
class AdminDashboardController extends Controller
{
    /**
     * Muestra el panel con el conteo de entradas, usuarios, autos y reservas.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $stats = [
            'posts' => Post::withTrashed()->count(),
            'users' => User::count(),
            'cars' => Car::count(),
            'bookings' => Booking::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
