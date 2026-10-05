<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        $title = $this->faker->words(3, true);
        return [
            'titulo' => ucfirst($title),
            'slug' => Str::slug($title),
            'contenido_json_bloques' => [
                [
                    'type' => 'hero',
                    'data' => [
                        'titulo' => ucfirst($title),
                        'subtitulo' => $this->faker->sentence(),
                        'boton_texto' => 'Conocer MÃ¡s',
                        'boton_url' => '#',
                    ]
                ],
                [
                    'type' => 'texto_imagen',
                    'data' => [
                        'titulo' => 'InformaciÃ³n Relevante',
                        'contenido' => $this->faker->paragraph(4),
                        'posicion_imagen' => 'derecha',
                    ]
                ]
            ],
            'status' => true,
            'meta_title' => ucfirst($title) . ' | Marcsol',
            'meta_description' => Str::limit($this->faker->paragraph(), 150),
            'og_image' => null,
            'schema_json' => null,
        ];
    }
}
