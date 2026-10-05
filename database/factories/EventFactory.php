<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        return [
            'titulo' => $title,
            'slug' => Str::slug($title),
            'descripcion' => $this->faker->paragraph(3),
            'imagen' => null,
            'fecha_evento' => now()->addDays(rand(2, 30))->setHour(rand(10, 18))->setMinute(0),
            'lugar' => 'Plaza Central Marcsol, Quevedo',
            'sucursal_id' => null,
            'status' => true,
            'meta_title' => $title . ' | Eventos Marcsol',
            'meta_description' => Str::limit($this->faker->paragraph(), 150),
            'og_image' => null,
            'schema_json' => null,
        ];
    }
}
