<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BranchFactory extends Factory
{
    protected $model = Branch::class;

    public function definition(): array
    {
        $name = 'Sucursal ' . $this->faker->streetName();
        return [
            'nombre' => $name,
            'slug' => Str::slug($name),
            'direccion' => $this->faker->address(),
            'ciudad' => 'Quevedo',
            'telefono' => '+593 5 ' . $this->faker->numerify('2######'),
            'email' => $this->faker->companyEmail(),
            'mapa_lat' => -1.0286 + ($this->faker->randomFloat(4, -0.02, 0.02)),
            'mapa_lng' => -79.4635 + ($this->faker->randomFloat(4, -0.02, 0.02)),
            'horarios' => 'Lunes a SÃ¡bado: 07:30 - 21:00 | Domingo: 08:00 - 19:00',
            'imagen' => null,
            'status' => true,
        ];
    }
}
