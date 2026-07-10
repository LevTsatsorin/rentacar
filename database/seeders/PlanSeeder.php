<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Básico',
                'slug' => 'basico',
                'price_multiplier' => 1.00,
                'description' => 'Seguro básico y kilometraje limitado. Ideal para trayectos cortos.',
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'price_multiplier' => 1.25,
                'description' => 'Seguro con franquicia reducida y kilometraje libre.',
            ],
            [
                'name' => 'Full',
                'slug' => 'full',
                'price_multiplier' => 1.50,
                'description' => 'Cobertura total, kilometraje libre, conductor adicional y asistencia 24 h.',
            ],
        ];

        foreach ($plans as $data) {
            Plan::updateOrCreate(
                ['slug' => $data['slug']],
                $data + ['is_active' => true],
            );
        }
    }
}
