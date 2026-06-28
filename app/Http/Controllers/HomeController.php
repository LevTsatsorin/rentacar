<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\CarService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(CarService $cars): View
    {
        $featuredCars = $cars->getFeaturedCars(3);
        $latestPosts = Post::published()->with('category')->latest()->limit(3)->get();

        return view('home.index', compact('featuredCars', 'latestPosts'));
    }
}
