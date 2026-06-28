<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@rentacar.test')->firstOrFail();
        $lucia = User::where('email', 'lucia@rentacar.test')->firstOrFail();
        $martin = User::where('email', 'martin@rentacar.test')->firstOrFail();

        $categories = Category::pluck('id', 'slug');
        $tags = Tag::pluck('id', 'slug');

        $posts = [
            [
                'title' => 'Cómo elegir el auto ideal para tu próximo viaje',
                'slug' => 'como-elegir-auto-ideal-viaje',
                'excerpt' => 'Tres claves para acertar con el modelo según el tipo de ruta y la cantidad de pasajeros.',
                'content' => 'Antes de reservar, considerá la distancia, el tipo de ruta y la carga. Para ciudad, un compacto rinde mejor. Para viajes largos, priorizá confort y consumo. Si vas en familia, los SUV ganan en espacio.',
                'image' => 'blog/elegir-auto.jpg',
                'category' => 'consejos',
                'author_id' => $admin->id,
                'is_active' => true,
                'tags' => ['ciudad', 'ruta', 'familia'],
            ],
            [
                'title' => 'Novedades en nuestra flota: llegan los modelos 2024',
                'slug' => 'novedades-flota-modelos-2024',
                'excerpt' => 'Sumamos cinco unidades nuevas a la flota. Conocelas antes que nadie.',
                'content' => 'Este mes incorporamos modelos 2024 con caja automática y mayor eficiencia de combustible. La Chevrolet Tracker ya está disponible para reservar.',
                'image' => 'blog/flota-2024.jpg',
                'category' => 'noticias',
                'author_id' => $lucia->id,
                'is_active' => true,
                'tags' => ['suv', 'mantenimiento'],
            ],
            [
                'title' => 'Review: Volkswagen Golf 2023 — una semana al volante',
                'slug' => 'review-volkswagen-golf-2023',
                'excerpt' => 'Probamos el Golf 2023 durante siete días. Esto es lo que encontramos.',
                'content' => 'El Golf mantiene su ADN: manejo preciso, materiales sólidos y consumo contenido. Donde más nos sorprendió fue en la caja automática DSG, suave en ciudad y reactiva en ruta.',
                'image' => 'blog/golf-review.jpg',
                'category' => 'reviews',
                'author_id' => $martin->id,
                'is_active' => true,
                'tags' => ['ruta', 'ahorro'],
            ],
            [
                'title' => 'Consejos para alquilar un auto por primera vez',
                'slug' => 'consejos-alquilar-auto-primera-vez',
                'excerpt' => 'Documentación, seguros y revisión previa: lo básico que tenés que saber.',
                'content' => 'Llevá DNI y licencia vigente. Revisá la cobertura del seguro antes de firmar. Hacé el chequeo visual del vehículo junto al operador y registrá cualquier detalle preexistente.',
                'image' => 'blog/primera-vez.jpg',
                'category' => 'consejos',
                'author_id' => $admin->id,
                'is_active' => true,
                'tags' => ['seguros', 'ahorro'],
            ],
            [
                'title' => 'Promoción de invierno: 20% off en alquileres semanales',
                'slug' => 'promocion-invierno-alquiler-semanal',
                'excerpt' => 'Durante junio y julio, descuento del 20% en reservas de 7 días o más.',
                'content' => 'Aprovechá el descuento en toda la flota disponible. La promoción aplica reservando con al menos 48 horas de anticipación y no es acumulable con otros beneficios.',
                'image' => 'blog/promo-invierno.jpg',
                'category' => 'noticias',
                'author_id' => $lucia->id,
                'is_active' => true,
                'tags' => ['promociones', 'ahorro'],
            ],
            [
                'title' => 'Borrador interno: nuevas tarifas (no publicar)',
                'slug' => 'borrador-nuevas-tarifas',
                'excerpt' => 'Documento de trabajo interno.',
                'content' => 'Texto pendiente de revisión por administración.',
                'image' => null,
                'category' => 'noticias',
                'author_id' => $admin->id,
                'is_active' => false,
                'tags' => [],
            ],
        ];

        foreach ($posts as $data) {
            $tagSlugs = $data['tags'];
            $data['category_id'] = $categories[$data['category']];
            unset($data['tags'], $data['category']);

            $post = Post::updateOrCreate(['slug' => $data['slug']], $data);
            $post->tags()->sync($tags->only($tagSlugs)->values()->all());
        }
    }
}
