<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\CarService;
use Illuminate\View\View;

/**
 * Controlador de la página de inicio.
 */
class HomeController extends Controller
{
    /**
     * Muestra la portada con autos destacados y últimas publicaciones.
     *
     * @param  \App\Services\CarService  $cars
     * @return \Illuminate\View\View
     */
    public function index(CarService $cars): View
    {
        $featuredCars = $cars->getFeaturedCars(3);
        $latestPosts = Post::published()->with('category')->latest()->limit(3)->get();

        return view('home.index', compact('featuredCars', 'latestPosts'));
    }
}
