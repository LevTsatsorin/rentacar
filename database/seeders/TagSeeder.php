<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Ciudad' => 'ciudad',
            'Ruta' => 'ruta',
            'Familia' => 'familia',
            'Ahorro' => 'ahorro',
            'Mantenimiento' => 'mantenimiento',
            'Seguros' => 'seguros',
            'Promociones' => 'promociones',
            'SUV' => 'suv',
        ];

        foreach ($tags as $name => $slug) {
            Tag::updateOrCreate(['slug' => $slug], ['name' => $name]);
        }
    }
}
