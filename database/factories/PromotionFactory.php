<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PromotionFactory extends Factory
{
    protected $model = Promotion::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        return [
            'titulo' => $title,
            'slug' => Str::slug($title),
            'descripcion' => $this->faker->paragraph(2),
            'imagen' => null,
            'banner' => null,
            'pdf_volante' => null,
            'fecha_inicio' => now()->subDays(rand(1, 5)),
            'fecha_fin' => now()->addDays(rand(5, 20)),
            'es_promocion_del_dia' => false,
            'category_id' => Category::factory(),
            'sucursal_id' => null,
            'status' => true,
            'meta_title' => $title . ' | Marcsol Quevedo',
            'meta_description' => Str::limit($this->faker->paragraph(), 150),
            'og_image' => null,
            'schema_json' => null,
        ];
    }
}
