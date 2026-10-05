<?php

namespace Database\Factories;

use App\Models\Redirect301;
use Illuminate\Database\Eloquent\Factories\Factory;

class Redirect301Factory extends Factory
{
    protected $model = Redirect301::class;

    public function definition(): array
    {
        return [
            'url_origen' => '/antigua-ruta-' . $this->faker->unique()->slug(),
            'url_destino' => '/promociones',
            'status' => true,
            'hits' => 0,
        ];
    }
}
