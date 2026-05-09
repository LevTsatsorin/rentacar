<?php

namespace App\Services;

use App\Models\Car;
use Illuminate\Database\Eloquent\Collection;

class CarService
{
    public function getAvailableCars(): Collection
    {
        return Car::available()->orderBy('brand')->get();
    }

    public function getFeaturedCars(int $limit = 3): Collection
    {
        return Car::available()->orderByDesc('year')->limit($limit)->get();
    }

    public function findCar(int $id): ?Car
    {
        return Car::find($id);
    }
}
