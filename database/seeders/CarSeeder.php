<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            [
                'brand' => 'Toyota',
                'model' => 'Corolla',
                'year' => 2023,
                'daily_price' => 45.00,
                'transmission' => 'automatic',
                'seats' => 5,
                'image' => 'cars/corolla.jpg',
                'is_available' => true,
                'description' => 'Sedán compacto, ideal para ciudad. Bajo consumo y maletero amplio.',
            ],
            [
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => 2022,
                'daily_price' => 50.00,
                'transmission' => 'manual',
                'seats' => 5,
                'image' => 'cars/civic.jpg',
                'is_available' => true,
                'description' => 'Deportivo y eficiente, perfecto para viajes largos.',
            ],
            [
                'brand' => 'Ford',
                'model' => 'Focus',
                'year' => 2021,
                'daily_price' => 40.00,
                'transmission' => 'manual',
                'seats' => 5,
                'image' => 'cars/focus.jpg',
                'is_available' => true,
                'description' => 'Hatchback ágil con buena relación precio/calidad.',
            ],
            [
                'brand' => 'Volkswagen',
                'model' => 'Golf',
                'year' => 2023,
                'daily_price' => 55.00,
                'transmission' => 'automatic',
                'seats' => 5,
                'image' => 'cars/golf.jpg',
                'is_available' => true,
                'description' => 'Clásico alemán, confort y prestaciones de gama media-alta.',
            ],
            [
                'brand' => 'Renault',
                'model' => 'Sandero',
                'year' => 2022,
                'daily_price' => 35.00,
                'transmission' => 'manual',
                'seats' => 5,
                'image' => 'cars/sandero.jpg',
                'is_available' => true,
                'description' => 'Económico y práctico para uso urbano diario.',
            ],
            [
                'brand' => 'Chevrolet',
                'model' => 'Tracker',
                'year' => 2024,
                'daily_price' => 70.00,
                'transmission' => 'automatic',
                'seats' => 5,
                'image' => 'cars/tracker.jpg',
                'is_available' => true,
                'description' => 'SUV compacta, posición de manejo elevada y caja automática.',
            ],
            [
                'brand' => 'Peugeot',
                'model' => '208',
                'year' => 2023,
                'daily_price' => 42.00,
                'transmission' => 'manual',
                'seats' => 5,
                'image' => 'cars/208.jpg',
                'is_available' => false,
                'description' => 'Diseño moderno y eficiente. Ideal para escapadas cortas.',
            ],
            [
                'brand' => 'Fiat',
                'model' => 'Cronos',
                'year' => 2022,
                'daily_price' => 38.00,
                'transmission' => 'manual',
                'seats' => 5,
                'image' => 'cars/cronos.jpg',
                'is_available' => true,
                'description' => 'Sedán familiar con maletero generoso y consumo contenido.',
            ],
        ];

        foreach ($cars as $data) {
            Car::create($data);
        }
    }
}
