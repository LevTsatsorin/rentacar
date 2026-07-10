<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StatsService;
use Illuminate\View\View;

/**
 * Muestra el panel de administración con estadísticas generales.
 */
class AdminDashboardController extends Controller
{
    /**
     * Muestra el panel con las estadísticas calculadas desde la base de datos.
     *
     * @param  \App\Services\StatsService  $stats
     * @return \Illuminate\View\View
     */
    public function index(StatsService $stats): View
    {
        return view('admin.dashboard', ['stats' => $stats->forDashboard()]);
    }
}
