<?php

namespace App\Services;

use App\Models\Car;
use Illuminate\Database\Eloquent\Collection;

/**
 * Lógica de negocio para la consulta de autos disponibles para alquiler.
 */
class CarService
{
    /**
     * Devuelve todos los autos disponibles ordenados por marca.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableCars(): Collection
    {
        return Car::available()->orderBy('brand')->get();
    }

    /**
     * Devuelve los autos destacados (más nuevos) disponibles.
     *
     * @param  int  $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFeaturedCars(int $limit = 3): Collection
    {
        return Car::available()->orderByDesc('year')->limit($limit)->get();
    }
}
