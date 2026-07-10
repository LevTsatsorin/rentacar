<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Calcula las estadísticas del panel de administración desde la base de datos.
 */
class StatsService
{
    /**
     * Nombres de los meses en español, indexados de 1 a 12.
     *
     * @var array<int, string>
     */
    private const MONTHS = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
    ];

    /**
     * Devuelve las estadísticas relevantes para el dashboard.
     *
     * @return array<string, mixed>
     */
    public function forDashboard(): array
    {
        $topCar = Booking::select('car_id', DB::raw('COUNT(*) as total'))
            ->groupBy('car_id')->orderByDesc('total')->with('car')->first();

        $topPlan = Booking::whereNotNull('plan_id')
            ->select('plan_id', DB::raw('COUNT(*) as total'))
            ->groupBy('plan_id')->orderByDesc('total')->with('plan')->first();

        $topMonth = Booking::where('status', 'confirmed')
            ->select(DB::raw('MONTH(start_date) as month'), DB::raw('SUM(total_price) as total'))
            ->groupBy('month')->orderByDesc('total')->first();

        return [
            'posts' => Post::withTrashed()->count(),
            'users' => User::count(),
            'cars' => Car::count(),
            'bookings' => Booking::count(),
            'revenue' => (float) Booking::where('status', 'confirmed')->sum('total_price'),
            'topCar' => $topCar?->car,
            'topCarCount' => (int) ($topCar?->total ?? 0),
            'topPlan' => $topPlan?->plan,
            'topPlanCount' => (int) ($topPlan?->total ?? 0),
            'topMonth' => $topMonth ? [
                'label' => self::MONTHS[(int) $topMonth->month] ?? '—',
                'total' => (float) $topMonth->total,
            ] : null,
        ];
    }
}
