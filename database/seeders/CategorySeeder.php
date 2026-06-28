<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Consejos', 'slug' => 'consejos'],
            ['name' => 'Noticias', 'slug' => 'noticias'],
            ['name' => 'Reviews', 'slug' => 'reviews'],
        ];

        foreach ($categories as $data) {
            Category::updateOrCreate(
                ['slug' => $data['slug']],
                $data + ['is_active' => true],
            );
        }
    }
}
